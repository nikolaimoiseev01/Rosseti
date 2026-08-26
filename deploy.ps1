param(
    [int]$Commits = 1,

    [string]$Server = "RS\adm_Klimov-AE@10.19.177.162",

    [string]$RemoteProject = "/var/www/astro-2025-sr",

    [string]$TransferRoot = "\\tsclient\D\rosseti-transfer",

    [string]$GitExe = "C:\Temp\PortableGit\cmd\git.exe"
)

$ErrorActionPreference = "Stop"

# ------------------------------------------------------------
# Проверки
# ------------------------------------------------------------

if ($Commits -lt 1) {
    throw "Commits must be >= 1"
}

if (-not (Test-Path $GitExe)) {
    throw "Git not found: $GitExe"
}

$ProjectRoot = (Get-Location).Path
$ProjectRoot = $ProjectRoot -replace '^Microsoft\.PowerShell\.Core\\FileSystem::', ''
Write-Host "ProjectRoot: $ProjectRoot"

Write-Host ""
Write-Host "========================================="
Write-Host " Laravel deployment"
Write-Host "========================================="
Write-Host "Project:  $ProjectRoot"
Write-Host "Commits:  $Commits"
Write-Host "Server:   $Server"
Write-Host "Remote:   $RemoteProject"
Write-Host ""

# Проверяем, что мы внутри Git repository
& $GitExe rev-parse --is-inside-work-tree *> $null

if ($LASTEXITCODE -ne 0) {
    throw "This folder is not Git repository."
}

# ------------------------------------------------------------
# Определяем HEAD
# ------------------------------------------------------------

$HeadHash = (& $GitExe rev-parse --short HEAD).Trim()

if ($LASTEXITCODE -ne 0) {
    throw "Не удалось определить HEAD."
}

$HeadFullHash = (& $GitExe rev-parse HEAD).Trim()

$Timestamp = Get-Date -Format "yyyyMMdd-HHmmss"

$TransferId = "$Timestamp-$HeadHash"

$LocalTransferDir = Join-Path $TransferRoot $TransferId
$ZipName = "$TransferId.zip"
$ZipPath = Join-Path $LocalTransferDir $ZipName

$DeletedManifestName = "deleted-files.txt"
$DeletedManifestPath = Join-Path $LocalTransferDir $DeletedManifestName

$RemoteTransferDir = "$RemoteProject/rosseti-transfer/$TransferId"
$RemoteZip = "$RemoteTransferDir/$ZipName"
$RemoteDeletedManifest = "$RemoteTransferDir/$DeletedManifestName"

# ------------------------------------------------------------
# Определяем диапазон Git
#
# Commits = 1:
#   HEAD~1 -> HEAD
#
# Commits = 3:
#   HEAD~3 -> HEAD
# ------------------------------------------------------------

$BaseRevision = "HEAD~$Commits"

& $GitExe rev-parse $BaseRevision *> $null

if ($LASTEXITCODE -ne 0) {
    throw "Could not find $BaseRevision. Maybe repository less than $Commits commits."
}

Write-Host "Git range:"
Write-Host "  $BaseRevision -> HEAD"
Write-Host ""

Write-Host "Commits:"
& $GitExe log --oneline -n $Commits

Write-Host ""

# ------------------------------------------------------------
# Получаем изменения
# ------------------------------------------------------------

$GitChanges = & $GitExe diff --name-status -M $BaseRevision HEAD

if ($LASTEXITCODE -ne 0) {
    throw "git diff end with error."
}

if (-not $GitChanges) {
    Write-Host "No changes for deployment."
    exit 0
}

$FilesToArchive = New-Object System.Collections.Generic.List[string]
$DeletedFiles = New-Object System.Collections.Generic.List[string]

Write-Host "========================================="
Write-Host " Files"
Write-Host "========================================="

foreach ($Line in $GitChanges) {

    $Parts = $Line -split "`t"

    $Status = $Parts[0]

    # Rename:
    # R100    old/path.php    new/path.php
    if ($Status -match "^R") {

        $OldPath = $Parts[1]
        $NewPath = $Parts[2]

        Write-Host "RENAMED   $OldPath -> $NewPath"

        $DeletedFiles.Add($OldPath)
        $FilesToArchive.Add($NewPath)

        continue
    }

    # Copy
    if ($Status -match "^C") {

        $NewPath = $Parts[2]

        Write-Host "COPIED    $NewPath"

        $FilesToArchive.Add($NewPath)

        continue
    }

    $File = $Parts[1]

    switch -Regex ($Status) {

        "^D" {
            Write-Host "DELETED   $File"
            $DeletedFiles.Add($File)
        }

        "^A" {
            Write-Host "ADDED     $File"
            $FilesToArchive.Add($File)
        }

        "^M" {
            Write-Host "MODIFIED  $File"
            $FilesToArchive.Add($File)
        }

        default {
            Write-Host "$Status    $File"

            if (Test-Path (Join-Path $ProjectRoot $File)) {
                $FilesToArchive.Add($File)
            }
        }
    }
}

Write-Host ""

# Убираем дубликаты
$FilesToArchive = @($FilesToArchive | Sort-Object -Unique)
$DeletedFiles = @($DeletedFiles | Sort-Object -Unique)

# ------------------------------------------------------------
# Создаём локальную deployment-папку
# ------------------------------------------------------------

New-Item -ItemType Directory -Force -Path $LocalTransferDir | Out-Null

Write-Host "Transfer directory:"
Write-Host "  $LocalTransferDir"
Write-Host ""

# ------------------------------------------------------------
# Создаём ZIP с сохранением структуры директорий
# ------------------------------------------------------------

if ($FilesToArchive.Count -gt 0) {

    Add-Type -AssemblyName System.IO.Compression
    Add-Type -AssemblyName System.IO.Compression.FileSystem

    if (Test-Path $ZipPath) {
        Remove-Item $ZipPath -Force
    }

    $ZipStream = [System.IO.File]::Open(
        $ZipPath,
        [System.IO.FileMode]::Create
    )

    try {

        $Archive = New-Object System.IO.Compression.ZipArchive(
            $ZipStream,
            [System.IO.Compression.ZipArchiveMode]::Create
        )

        try {

            foreach ($File in $FilesToArchive) {

                $FullPath = Join-Path $ProjectRoot $File

                if (-not (Test-Path $FullPath -PathType Leaf)) {
                    Write-Warning "File not found and will be scipped: $File"
                    continue
                }

                # ZIP использует /
                $EntryName = $File.Replace("\", "/")

                Write-Host "ZIP       $EntryName"

                [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile(
                    $Archive,
                    $FullPath,
                    $EntryName,
                    [System.IO.Compression.CompressionLevel]::Optimal
                ) | Out-Null
            }

        }
        finally {
            $Archive.Dispose()
        }

    }
    finally {
        $ZipStream.Dispose()
    }

}
else {

    Write-Host "No files for ZIP."
}

# ------------------------------------------------------------
# Manifest удалённых файлов
# ------------------------------------------------------------

if ($DeletedFiles.Count -gt 0) {

    $DeletedFiles |
        Set-Content -Path $DeletedManifestPath -Encoding UTF8

    Write-Host ""
    Write-Host "Deleted files manifest:"
    Write-Host "  $DeletedManifestPath"
}

# ------------------------------------------------------------
# Информация
# ------------------------------------------------------------

Write-Host ""
Write-Host "========================================="
Write-Host " Deployment package"
Write-Host "========================================="

if (Test-Path $ZipPath) {
    $ZipInfo = Get-Item $ZipPath

    Write-Host "ZIP:"
    Write-Host "  $ZipPath"
    Write-Host "  Size: $([math]::Round($ZipInfo.Length / 1KB, 2)) KB"
}

Write-Host ""
Write-Host "Remote transfer:"
Write-Host "  $RemoteTransferDir"

Write-Host ""
Write-Host "========================================="
Write-Host " Creating remote directory"
Write-Host "========================================="
Write-Host ""

# ------------------------------------------------------------
# Создаём папку на Ubuntu
# ------------------------------------------------------------

ssh $Server "mkdir -p '$RemoteTransferDir'"

if ($LASTEXITCODE -ne 0) {
    throw "Could not create temp folder on Ubuntu."
}

# ------------------------------------------------------------
# SCP ZIP
# ------------------------------------------------------------

if (Test-Path $ZipPath) {

    Write-Host ""
    Write-Host "========================================="
    Write-Host " Uploading ZIP"
    Write-Host "========================================="
    Write-Host ""

    scp $ZipPath "${Server}:$RemoteZip"

    if ($LASTEXITCODE -ne 0) {
        throw "SCP ZIP ended with error."
    }
}

# ------------------------------------------------------------
# SCP deleted manifest
# ------------------------------------------------------------

if (Test-Path $DeletedManifestPath) {

    Write-Host ""
    Write-Host "Uploading deleted-files manifest..."

    scp $DeletedManifestPath "${Server}:$RemoteDeletedManifest"

    if ($LASTEXITCODE -ne 0) {
        throw "SCP deleted-files.txt завершился с ошибкой."
    }
}

# ------------------------------------------------------------
# Deploy на Ubuntu
# ------------------------------------------------------------

Write-Host ""
Write-Host "========================================="
Write-Host " Deploying on Ubuntu"
Write-Host "========================================="
Write-Host ""

# Распаковываем ZIP
if (Test-Path $ZipPath) {

    Write-Host "Extracting ZIP..."

    ssh $Server "unzip -o '$RemoteZip' -d '$RemoteProject'"

    if ($LASTEXITCODE -ne 0) {
        throw "Could not unZIP on Ubuntu."
    }
}

# Удаляем файлы, которые были удалены в Git
if ($DeletedFiles.Count -gt 0) {

    Write-Host ""
    Write-Host "Deleting files removed from Git..."

    foreach ($File in $DeletedFiles) {

        # Git использует /
        $RemoteFile = "$RemoteProject/$File"

        Write-Host "DELETE    $RemoteFile"

        ssh $Server "rm -f -- '$RemoteFile'"

        if ($LASTEXITCODE -ne 0) {
            throw "Couldnt delete file: $RemoteFile"
        }
    }
}

Write-Host ""
Write-Host "========================================="
Write-Host " SUCCESS"
Write-Host "========================================="
Write-Host ""
Write-Host "Commit: $HeadFullHash"
Write-Host "Package:"
Write-Host "  $LocalTransferDir"
Write-Host ""
