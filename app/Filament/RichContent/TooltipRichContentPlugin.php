<?php

namespace App\Filament\RichContent;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\EditorCommand;
use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Forms\Components\TextInput;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Icons\Heroicon;
use Tiptap\Core\Extension;

class TooltipRichContentPlugin implements RichContentPlugin
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
            app(TooltipMark::class),
        ];
    }

    /**
     * @return array<string>
     */
    public function getTipTapJsExtensions(): array
    {
        return [
            FilamentAsset::getScriptSrc(
                'rich-content-plugins/tooltip'
            ),
        ];
    }

    /**
     * @return array<RichEditorTool>
     */
    public function getEditorTools(): array
    {
        return [
            RichEditorTool::make('tooltip')
                ->label('Добавить подсказку')
                ->icon(Heroicon::InformationCircle)
                ->activeKey('tooltip')
                ->action(
                    arguments: <<<'JS'
                    {
                        text: $getEditor()
                            ?.getAttributes('tooltip')
                            ?.text ?? ''
                    }
                    JS,
                ),

            RichEditorTool::make('removeTooltip')
                ->label('Удалить подсказку')
                ->icon(Heroicon::XCircle)
                ->activeKey('tooltip')
                ->activeStyling(false)
                ->disabledWhenNotActive()
                ->jsHandler(
                    <<<'JS'
                    $getEditor()
                        ?.chain()
                        .focus()
                        .unsetTooltip()
                        .run()
                    JS,
                ),
        ];
    }

    /**
     * @return array<Action>
     */
    public function getEditorActions(): array
    {
        return [
            Action::make('tooltip')
                ->modalHeading('Подсказка')
                ->modalDescription(
                    'Введите текст, который появится при наведении.'
                )
                ->fillForm(
                    fn (array $arguments): array => [
                        'text' => $arguments['text'] ?? '',
                    ],
                )
                ->schema([
                    TextInput::make('text')
                        ->label('Текст подсказки')
                        ->required()
                        ->maxLength(300),
                ])
                ->action(
                    function (
                        array $arguments,
                        array $data,
                        RichEditor $component,
                    ): void {
                        $component->runCommands(
                            [
                                EditorCommand::make(
                                    'setTooltip',
                                    arguments: [
                                        [
                                            'text' => trim(
                                                $data['text']
                                            ),
                                        ],
                                    ],
                                ),
                            ],
                            editorSelection:
                            $arguments['editorSelection'],
                        );
                    },
                ),
        ];
    }
}
