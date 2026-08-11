<?php

namespace App\Filament\RichContent;

use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Icons\Heroicon;
use Tiptap\Core\Extension;

class CheckmarkRichContentPlugin implements RichContentPlugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * @return array<Extension>
     */
    public function getTipTapPhpExtensions(): array
    {
        return [
            app(CheckmarkNode::class),
        ];
    }

    /**
     * @return array<string>
     */
    public function getTipTapJsExtensions(): array
    {
        // Указываем путь к нашему JS-скрипту (без .js)
        return [
            FilamentAsset::getScriptSrc(
                'rich-content-plugins/checkmark'
            ),
        ];
    }

    /**
     * @return array<RichEditorTool>
     */
    public function getEditorTools(): array
    {
        return [
            RichEditorTool::make('checkmark')
                ->label('Вставить галочку')
                ->icon(Heroicon::CheckCircle)
                ->jsHandler(
                    <<<'JS'
                    $getEditor()
                        ?.chain()
                        .focus()
                        .insertCheckmark()
                        .run()
                    JS,
                ),
        ];
    }

    public function getEditorActions(): array
    {
        return [];
    }
}
