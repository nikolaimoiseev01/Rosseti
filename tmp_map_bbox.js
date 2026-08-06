import fs from 'fs';
const src = fs.readFileSync('resources/views/components/custom-page-blocks/map.blade.php', 'utf8');

const regionRe = /data-region="([^"]+)"[^>]*?data-code="([^"]+)"\s*[\r\n\s]*d="([^"]+)"/g;

function bboxOfPath(d) {
    let x = 0, y = 0, sx = 0, sy = 0;
    let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
    const tokens = d.match(/[a-zA-Z]|-?\d*\.?\d+(?:e-?\d+)?/g);
    if (!tokens) return null;
    let i = 0, cmd = null;
    const upd = () => { minX = Math.min(minX, x); maxX = Math.max(maxX, x); minY = Math.min(minY, y); maxY = Math.max(maxY, y); };
    const num = () => parseFloat(tokens[i++]);
    while (i < tokens.length) {
        if (/[a-zA-Z]/.test(tokens[i])) cmd = tokens[i++];
        switch (cmd) {
            case 'M': x = num(); y = num(); sx = x; sy = y; upd(); cmd = 'L'; break;
            case 'm': x += num(); y += num(); sx = x; sy = y; upd(); cmd = 'l'; break;
            case 'L': x = num(); y = num(); upd(); break;
            case 'l': x += num(); y += num(); upd(); break;
            case 'H': x = num(); upd(); break;
            case 'h': x += num(); upd(); break;
            case 'V': y = num(); upd(); break;
            case 'v': y += num(); upd(); break;
            case 'C': num(); num(); num(); num(); x = num(); y = num(); upd(); break;
            case 'c': num(); num(); num(); num(); x += num(); y += num(); upd(); break;
            case 'S': case 'Q': num(); num(); x = num(); y = num(); upd(); break;
            case 's': case 'q': num(); num(); x += num(); y += num(); upd(); break;
            case 'T': x = num(); y = num(); upd(); break;
            case 't': x += num(); y += num(); upd(); break;
            case 'A': num(); num(); num(); num(); num(); x = num(); y = num(); upd(); break;
            case 'a': num(); num(); num(); num(); num(); x += num(); y += num(); upd(); break;
            case 'Z': case 'z': x = sx; y = sy; break;
            default: i++; break;
        }
    }
    return { minX, minY, maxX, maxY, cx: (minX + maxX) / 2, cy: (minY + maxY) / 2 };
}

const wanted = ['RU-KGD','RU-SPE','RU-MOW','RU-MOS','RU-NIZ','RU-SAR','RU-ROS','RU-STA','RU-CE','RU-SVE','RU-TYU','RU-TOM','RU-NVS','RU-KYA','RU-TY'];
let m;
while ((m = regionRe.exec(src)) !== null) {
    const [, region, code, d] = m;
    if (!wanted.includes(code)) continue;
    const b = bboxOfPath(d);
    console.log(`${code}\t${region}\tbbox=[${b.minX.toFixed(0)},${b.minY.toFixed(0)} - ${b.maxX.toFixed(0)},${b.maxY.toFixed(0)}]\tcenter=(${b.cx.toFixed(0)},${b.cy.toFixed(0)})`);
}
