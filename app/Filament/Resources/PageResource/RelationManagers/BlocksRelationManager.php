<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use App\Filament\RichContent\TooltipRichContentPlugin;
use App\Filament\RichContent\CheckmarkRichContentPlugin;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class BlocksRelationManager extends RelationManager
{
    protected static string $relationship = 'blocks';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->label('ID')
                    ->disabled()
                    ->hidden(fn ($context) => $context === 'create'),

                Select::make('type')
                    ->label('Тип блока')
                    ->required()
                    ->options([
                        'heading' => 'Заголовок',
                        'image' => 'Изображение',
                        'subtitle' => 'Подзаголовок',
                        'divider' => 'Разделитель',
//                        'text-with-title' => 'Текст с заголовком',
                        'rich_text' => 'Текстовый блок',
                        'two_columns' => 'Текст в две колонки',
                        'table' => 'Таблица',
                        'timeline' => 'Таймлайн',
                        'stats_grid' => 'Сетка показателей',
                        'quote' => 'Цитата',
                        'gri_reference' => 'GRI ссылка',
                        'image_row' => 'Изображения в ряд',
                        'key_figure' => 'Ключевая цифра',
                        'person_card' => 'Карточка сотрудника',
                        'info_block' => 'Информационный блок',
                        'numbered_steps' => 'Нумерованные шаги',
                        'cards_grid' => 'Сетка карточек',
                        'icon_list' => 'Перечисление с иконками',
                        'chart' => 'Диаграмма / График',
                        'donut_chart' => 'Круговая диаграмма',
                        'custom_html' => 'Custom HTML',
                        'custom_html_native' => 'Custom HTML (без Shadow DOM)',
                        'custom_component' => 'Кастомный компонент',
                    ])
                    ->live()
                    ->afterStateUpdated(function (Select $component): void {
                        $component
                            ->getContainer()
                            ->getComponent('blockSettings')
                            ?->getChildSchema()
                            ->fill();
                    }),

                Section::make('Настройки блока')
                    ->schema(
                        fn (Get $get): array => $this->getBlockFormSchema(
                            $get('type'),
                        ),
                    )
                    ->key('blockSettings')
                    ->columnSpanFull(),

                TextInput::make('sort')
                    ->label('Сортировка')
                    ->numeric()
                    ->default(0),
            ]);
    }

    private function getBlockFormSchema(?string $type): array
    {
        return match($type) {
            'text-with-title' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                TextInput::make('data_languages.ru.title')
                                    ->label('Заголовок'),
                                Forms\Components\RichEditor::make('data_languages.ru.text')
                                    ->label('Текст')
                                    ->required()
                                    ->live()
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('data_languages.en.title')
                                    ->label('Title'),
                                Forms\Components\RichEditor::make('data_languages.en.text')
                                    ->label('Text')
                                    ->live()
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                ...$this->textColorSelectFields('data_languages.color'),
                ...$this->spacingSelectFields(),
            ],

            'rich_text' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.ru.content')
                                    ->label('Содержимое')
                                    ->live()
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                        'textColor',
                                    ])
                                    ->required()
                                    ->textColors([
                                        '#00355A' => 'Тёмно-синий',
                                        '#005A99' => 'Синий',
                                        '#2196F3' => 'Голубой',
                                        '#595959' => 'Чёрный',
                                        '#ffffff' => 'Белый',
                                        'grey' => 'Серый',
                                    ])
                                    ->columnSpanFull()
                                    ->default('')
                                    ->fileAttachmentsVisibility('public'),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.en.content')
                                    ->label('Content')
                                    ->live()
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                        'textColor',
                                    ])
                                    ->columnSpanFull()
                                    ->default('')
                                    ->fileAttachmentsVisibility('public'),
                            ]),
                    ])
                    ->columnSpanFull(),
                ...$this->textColorSelectFields('data_languages.color'),
                ...$this->spacingSelectFields(),
            ],

            'image' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\FileUpload::make('data_languages.ru.url')
                                    ->label('Изображение')
                                    ->image()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'])
                                    ->directory('report-images')
                                    ->required(),
                                Forms\Components\TextInput::make('data_languages.ru.caption')
                                    ->label('Подпись к изображению'),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\FileUpload::make('data_languages.en.url')
                                    ->label('Image')
                                    ->image()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'])
                                    ->directory('report-images'),
                                Forms\Components\TextInput::make('data_languages.en.caption')
                                    ->label('Image caption'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.image_width')
                    ->label('Ширина блока')
                    ->options([
                        '100' => 'Полная ширина (100%)',
                        '75' => 'Три четверти (75%)',
                        '66' => 'Две трети (66%)',
                        '50' => 'Половина (50%)',
                        '33' => 'Треть (33%)',
                    ])
                    ->default('100'),
                Forms\Components\Toggle::make('data_languages.prevent_merge')
                    ->label('Начинать с новой строки')
                    ->helperText('Не объединять с соседними блоками')
                    ->default(false),
                ...$this->spacingSelectFields(),
            ],

            'two_columns' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.ru.left')
                                    ->label('Левая колонка')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('data_languages.ru.right')
                                    ->label('Правая колонка')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.en.left')
                                    ->label('Left column')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('data_languages.en.right')
                                    ->label('Right column')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                ...$this->spacingSelectFields(),
            ],

            'stats_grid' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.ru.items')
                                    ->label('Показатели')
                                    ->schema([
                                        Forms\Components\TextInput::make('value')
                                            ->label('Значение')
                                            ->required(),
                                        Forms\Components\TextInput::make('unit')
                                            ->label('Единица измерения'),
                                        Forms\Components\TextInput::make('description')
                                            ->label('Описание')
                                            ->required(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.en.items')
                                    ->label('Items')
                                    ->schema([
                                        Forms\Components\TextInput::make('value')
                                            ->label('Value'),
                                        Forms\Components\TextInput::make('unit')
                                            ->label('Unit'),
                                        Forms\Components\TextInput::make('description')
                                            ->label('Description'),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                ...$this->textColorSelectFields('data_languages.main_color', 'Цвет основной цифры'),
                ...$this->textColorSelectFields('data_languages.unit_color', 'Цвет единиц измерения'),
                ...$this->textColorSelectFields('data_languages.text_color', 'Цвет описания'),
                Forms\Components\Select::make('data_languages.background_color')
                    ->label('Цвет фона карточек')
                    ->options([
                        'transparent' => 'Прозрачный',
                        'white' => 'Белый',
                        'gray-50' => 'Светло-серый',
                        'gray-100' => 'Серый',
                        'gray-200' => 'Тёмно-серый',
                        'blue-50' => 'Светло-синий',
                        'blue-100' => 'Синий',
                        'blue-900' => 'Тёмно-синий',
                    ])
                    ->default('transparent'),
                Forms\Components\Select::make('data_languages.columns')
                    ->label('Количество колонок')
                    ->options([
                        'auto' => 'Авто (адаптивно)',
                        '2' => '2 колонки',
                        '3' => '3 колонки',
                        '4' => '4 колонки',
                    ])
                    ->default('auto'),
                ...$this->spacingSelectFields(),
            ],

            'quote' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\Textarea::make('data_languages.ru.text')
                                    ->label('Текст цитаты')
                                    ->rows(3)
                                    ->required(),
                                Forms\Components\TextInput::make('data_languages.ru.author')
                                    ->label('Автор'),
                                Forms\Components\TextInput::make('data_languages.ru.position')
                                    ->label('Должность'),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\Textarea::make('data_languages.en.text')
                                    ->label('Quote text')
                                    ->rows(3),
                                Forms\Components\TextInput::make('data_languages.en.author')
                                    ->label('Author'),
                                Forms\Components\TextInput::make('data_languages.en.position')
                                    ->label('Position'),
                            ]),
                    ])
                    ->columnSpanFull(),
                ...$this->spacingSelectFields()
            ],

            'heading' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.ru.content')
                                    ->label('Текст заголовка')
                                    ->required()
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('data_languages.ru.subtitle')
                                    ->label('Подзаголовок (маленький текст)')
                                    ->helperText('Отображается под заголовком мелким шрифтом')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.en.content')
                                    ->label('Heading text')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('data_languages.en.subtitle')
                                    ->label('Subtitle (small text)')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.font_weight')
                    ->label('Толщина шрифта')
                    ->options([
                        'font-light' => 'Тонкий (light)',
                        'font-normal' => 'Обычный (normal)',
                        'font-medium' => 'Средний (medium)',
                        'font-semibold' => 'Полужирный (semibold)',
                        'font-bold' => 'Жирный (bold)',
                        'font-extrabold' => 'Очень жирный (extrabold)',
                    ])
                    ->default('bold'),
                Forms\Components\Select::make('data_languages.level')
                    ->label('Уровень')
                    ->options([
                        'h1' => 'H1 — Главный',
                        'h2' => 'H2 — Крупный',
                        'h3' => 'H3 — Средний',
                        'h4' => 'H4 — Маленький',
                    ])
                    ->default('h2'),
                Forms\Components\Toggle::make('data_languages.is_big')
                    ->label('Большой заголовок')
                    ->helperText('Выделяется в навигации страницы и в меню хедера')
                    ->default(false),
                ...$this->textColorSelectFields('data_languages.color'),
                ...$this->spacingSelectFields(),
            ],

            'gri_reference' => [
                Forms\Components\TextInput::make('data_languages.codes')
                    ->label('Коды GRI')
                    ->helperText('Например: GRI 2-1, 2-6')
                    ->required(),
                ...$this->spacingSelectFields()
            ],

            'image_row' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.ru.images')
                                    ->label('Изображения')
                                    ->schema([
                                        Forms\Components\FileUpload::make('url')
                                            ->label('Изображение')
                                            ->image()
                                            ->disk('public')
                                            ->directory('report-images')
                                            ->required(),
                                        Forms\Components\TextInput::make('alt')
                                            ->label('Подпись (alt)'),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.en.images')
                                    ->label('Images')
                                    ->schema([
                                        Forms\Components\FileUpload::make('url')
                                            ->label('Image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('report-images'),
                                        Forms\Components\TextInput::make('alt')
                                            ->label('Alt text'),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.size')
                    ->label('Размер каждого элемента')
                    ->options([
                        'small' => 'Маленький (иконки, ~60px)',
                        'medium' => 'Средний (~120px)',
                        'large' => 'Большой (~200px)',
                        'xlarge' => 'Крупный (~300px)',
                        'xxlarge' => 'Очень крупный (~400px)',
                        'full' => 'На всю ширину (~500px)',
                        'ultra' => 'Ультра (~600px)',
                        'mega' => 'Мега (~800px)',
                    ])
                    ->default('small'),
                Forms\Components\Select::make('data_languages.gap')
                    ->label('Расстояние между')
                    ->options([
                        'tight' => 'Плотно (4px)',
                        'normal' => 'Обычно (12px)',
                        'wide' => 'Широко (24px)',
                    ])
                    ->default('normal'),
                ...$this->spacingSelectFields()
            ],

            'table' => [
                Forms\Components\Select::make('data_languages.header_style')
                    ->label('Цвет фона заголовков')
                    ->options([
                        'blue' => 'Тёмно-синий (#00355A)',
                        'medium_blue' => 'Синий (#005B9C)',
                        'brand_blue' => 'Фирменный голубой (#2196F3)',
                        'dark' => 'Тёмный (#1B2733)',
                        'light' => 'Светло-серый (#F0F4F8)',
                        'grey' => 'Серый (#E8EEF4)',
                        'light_blue' => 'Светло-голубой (#EBF4FF)',
                        'none' => 'Без фона',
                    ])
                    ->default('blue'),
                Forms\Components\Select::make('data_languages.header_text_color')
                    ->label('Цвет текста заголовков')
                    ->options([
                        'white' => 'Белый',
                        'dark' => 'Тёмный (#1A1A1A)',
                        'blue' => 'Синий (#00355A)',
                    ])
                    ->default('white'),
                Forms\Components\Select::make('data_languages.header_font_style')
                    ->label('Шрифт заголовков')
                    ->options([
                        'normal' => 'Обычный',
                        'medium' => 'Средний (medium)',
                        'bold' => 'Жирный (bold)',
                    ])
                    ->default('bold'),
                Forms\Components\Select::make('data_languages.cell_padding')
                    ->label('Отступы в ячейках')
                    ->options([
                        'compact' => 'Компактные',
                        'normal' => 'Обычные',
                        'spacious' => 'Просторные',
                    ])
                    ->default('normal'),
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.ru.headers')
                                    ->label('Заголовки столбцов')
                                    ->schema([
                                        Forms\Components\RichEditor::make('text')
                                            ->label('Название столбца')
                                            ->plugins([TooltipRichContentPlugin::make(), CheckmarkRichContentPlugin::make()])
                                            ->enableToolbarButtons(['tooltip',
                                        'checkmark', 'removeTooltip', 'textColor'])
                                            ->textColors([
                                                '#00355A' => 'Тёмно-синий',
                                                '#005A99' => 'Синий',
                                                '#2196F3' => 'Голубой',
                                                '#595959' => 'Чёрный',
                                                '#ffffff' => 'Белый',
                                                'grey' => 'Серый',
                                            ])
                                            ->fileAttachmentsVisibility('public')
                                            ->columnSpanFull(),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                                Forms\Components\Repeater::make('data_languages.ru.rows')
                                    ->label('Строки')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_accent')
                                            ->label('Акцентная строка (на всю ширину)')
                                            ->default(false),
                                        Forms\Components\Select::make('row_color')
                                            ->label('Цвет строки')
                                            ->options([
                                                '' => 'По умолчанию (чередование)',
                                                '#F0F4F8' => 'Светло-серый (итоги)',
                                                '#E8EEF4' => 'Серый',
                                                '#EBF4FF' => 'Светло-голубой',
                                                '#DBEAFE' => 'Голубой',
                                                '#E0F2FE' => 'Небесный',
                                                '#F0FFF4' => 'Светло-зелёный',
                                                '#FFFBEB' => 'Светло-жёлтый',
                                                '#2196F3' => 'Фирменный голубой (белый текст)',
                                                '#00355A' => 'Тёмно-синий (белый текст)',
                                                '#005B9C' => 'Синий (белый текст)',
                                            ])
                                            ->default('')
                                            ->visible(fn ($get) => !$get('is_accent')),
                                        Forms\Components\RichEditor::make('accent_text')
                                            ->label('Текст акцентной строки')
                                            ->plugins([TooltipRichContentPlugin::make(), CheckmarkRichContentPlugin::make()])
                                            ->enableToolbarButtons(['tooltip',
                                        'checkmark', 'removeTooltip', 'textColor'])
                                            ->textColors([
                                                '#00355A' => 'Тёмно-синий',
                                                '#005A99' => 'Синий',
                                                '#2196F3' => 'Голубой',
                                                '#595959' => 'Чёрный',
                                                '#ffffff' => 'Белый',
                                                'grey' => 'Серый',
                                            ])
                                            ->fileAttachmentsVisibility('public')
                                            ->columnSpanFull()
                                            ->visible(fn ($get) => $get('is_accent')),
                                        Forms\Components\Repeater::make('cells')
                                            ->label('Ячейки')
                                            ->schema([
                                                Forms\Components\RichEditor::make('text')
                                                    ->label('Значение')
                                                    ->plugins([TooltipRichContentPlugin::make(), CheckmarkRichContentPlugin::make()])
                                                    ->enableToolbarButtons(['tooltip',
                                        'checkmark', 'removeTooltip', 'textColor'])
                                                    ->textColors([
                                                        '#00355A' => 'Тёмно-синий',
                                                        '#005A99' => 'Синий',
                                                        '#2196F3' => 'Голубой',
                                                        '#595959' => 'Чёрный',
                                                        '#ffffff' => 'Белый',
                                                        'grey' => 'Серый',
                                                    ])
                                                    ->fileAttachmentsVisibility('public')
                                                    ->columnSpanFull(),
                                                Forms\Components\Select::make('colspan')
                                                    ->label('Объединение столбцов')
                                                    ->options([
                                                        '1' => '1 (без объединения)',
                                                        '2' => '2 столбца',
                                                        '3' => '3 столбца',
                                                        '4' => '4 столбца',
                                                        '5' => '5 столбцов',
                                                        '6' => '6 столбцов',
                                                    ])
                                                    ->default('1'),
                                            ])
                                            ->defaultItems(3)
                                            ->columnSpanFull()
                                            ->visible(fn ($get) => !$get('is_accent')),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.en.headers')
                                    ->label('Column headers')
                                    ->schema([
                                        Forms\Components\RichEditor::make('text')
                                            ->label('Column name')
                                            ->plugins([TooltipRichContentPlugin::make(), CheckmarkRichContentPlugin::make()])
                                            ->enableToolbarButtons(['tooltip',
                                        'checkmark', 'removeTooltip', 'textColor'])
                                            ->textColors([
                                                '#00355A' => 'Тёмно-синий',
                                                '#005A99' => 'Синий',
                                                '#2196F3' => 'Голубой',
                                                '#595959' => 'Чёрный',
                                                '#ffffff' => 'Белый',
                                                'grey' => 'Серый',
                                            ])
                                            ->fileAttachmentsVisibility('public')
                                            ->columnSpanFull(),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                                Forms\Components\Repeater::make('data_languages.en.rows')
                                    ->label('Rows')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_accent')
                                            ->label('Accent row (full width)')
                                            ->default(false),
                                        Forms\Components\Select::make('row_color')
                                            ->label('Row color')
                                            ->options([
                                                '' => 'Default (alternating)',
                                                '#F0F4F8' => 'Light grey (totals)',
                                                '#E8EEF4' => 'Grey',
                                                '#EBF4FF' => 'Light blue',
                                                '#DBEAFE' => 'Blue',
                                                '#E0F2FE' => 'Sky',
                                                '#F0FFF4' => 'Light green',
                                                '#FFFBEB' => 'Light yellow',
                                                '#2196F3' => 'Brand blue (white text)',
                                                '#00355A' => 'Dark blue (white text)',
                                                '#005B9C' => 'Blue (white text)',
                                            ])
                                            ->default('')
                                            ->visible(fn ($get) => !$get('is_accent')),
                                        Forms\Components\RichEditor::make('accent_text')
                                            ->label('Accent row text')
                                            ->plugins([TooltipRichContentPlugin::make(), CheckmarkRichContentPlugin::make()])
                                            ->enableToolbarButtons(['tooltip',
                                        'checkmark', 'removeTooltip', 'textColor'])
                                            ->textColors([
                                                '#00355A' => 'Тёмно-синий',
                                                '#005A99' => 'Синий',
                                                '#2196F3' => 'Голубой',
                                                '#595959' => 'Чёрный',
                                                '#ffffff' => 'Белый',
                                                'grey' => 'Серый',
                                            ])
                                            ->fileAttachmentsVisibility('public')
                                            ->columnSpanFull()
                                            ->visible(fn ($get) => $get('is_accent')),
                                        Forms\Components\Repeater::make('cells')
                                            ->label('Cells')
                                            ->schema([
                                                Forms\Components\RichEditor::make('text')
                                                    ->label('Value')
                                                    ->plugins([TooltipRichContentPlugin::make(), CheckmarkRichContentPlugin::make()])
                                                    ->enableToolbarButtons(['tooltip',
                                        'checkmark', 'removeTooltip', 'textColor'])
                                                    ->textColors([
                                                        '#00355A' => 'Тёмно-синий',
                                                        '#005A99' => 'Синий',
                                                        '#2196F3' => 'Голубой',
                                                        '#595959' => 'Чёрный',
                                                        '#ffffff' => 'Белый',
                                                        'grey' => 'Серый',
                                                    ])
                                                    ->fileAttachmentsVisibility('public')
                                                    ->columnSpanFull(),
                                                Forms\Components\Select::make('colspan')
                                                    ->label('Colspan')
                                                    ->options([
                                                        '1' => '1 (no merge)',
                                                        '2' => '2 columns',
                                                        '3' => '3 columns',
                                                        '4' => '4 columns',
                                                        '5' => '5 columns',
                                                        '6' => '6 columns',
                                                    ])
                                                    ->default('1'),
                                            ])
                                            ->defaultItems(3)
                                            ->columnSpanFull()
                                            ->visible(fn ($get) => !$get('is_accent')),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                ...$this->spacingSelectFields(),
            ],

            'key_figure' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.ru.value')
                                    ->label('Значение (число)')
                                    ->placeholder('725 млрд руб.')
                                    ->required(),
                                Forms\Components\TextInput::make('data_languages.ru.description')
                                    ->label('Описание')
                                    ->placeholder('инвестиции в модернизацию')
                                    ->required(),
                                Forms\Components\RichEditor::make('data_languages.ru.context')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->label('Контекст (необязательный текст рядом)')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.en.value')
                                    ->label('Value (number)')
                                    ->placeholder('725 bn RUB'),
                                Forms\Components\TextInput::make('data_languages.en.description')
                                    ->label('Description')
                                    ->placeholder('investments in modernization'),
                                Forms\Components\RichEditor::make('data_languages.en.context')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->label('Context (optional text)')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.style')
                    ->label('Стиль оформления')
                    ->options([
                        'card_blue' => 'Карточка (синий фон)',
                        'card_light' => 'Карточка (светлый фон)',
                        'inline_large' => 'Крупная цифра по центру',
                        'inline_left' => 'Цифра слева, текст справа',
                        'accent_border' => 'С акцентной полоской слева',
                    ])
                    ->default('card_blue'),
                ...$this->textColorSelectFields('data_languages.main_color', 'Цвет цифры'),
                ...$this->textColorSelectFields('data_languages.text_color', 'Цвет описания'),
                ...$this->textColorSelectFields('data_languages.context_color', 'Цвет контекста'),
                ...$this->textColorSelectFields('data_languages.bg_color', 'Цвет фона', true),
                ...$this->spacingSelectFields(),
            ],

            'subtitle' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.ru.text')
                                    ->label('Текст подзаголовка')
                                    ->required(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.en.text')
                                    ->label('Subtitle text'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.style')
                    ->label('Стиль')
                    ->options([
                        'default' => 'Обычный (чёрный)',
                        'accent' => 'Акцентный (цветной)',
                        'uppercase' => 'Капслок (маленький, трекинг)',
                    ])
                    ->default('default'),
                Forms\Components\Select::make('data_languages.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
                ...$this->spacingSelectFields(),
            ],

            'person_card' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.ru.heading')
                                    ->label('Заголовок (вопрос)')
                                    ->placeholder('Как экологическая ответственность проявляется...'),
                                Forms\Components\RichEditor::make('data_languages.ru.text')
                                    ->label('Текст / цитата')
                                    ->required()
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('data_languages.ru.photo')
                                    ->label('Фото')
                                    ->image()
                                    ->directory('report-images')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('1:1'),
                                Forms\Components\TextInput::make('data_languages.ru.name')
                                    ->label('Имя')
                                    ->required(),
                                Forms\Components\TextInput::make('data_languages.ru.position')
                                    ->label('Должность'),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.en.heading')
                                    ->label('Heading (question)')
                                    ->placeholder('How environmental responsibility manifests...'),
                                Forms\Components\RichEditor::make('data_languages.en.text')
                                    ->label('Text / quote')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('data_languages.en.photo')
                                    ->label('Photo')
                                    ->image()
                                    ->directory('report-images')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('1:1'),
                                Forms\Components\TextInput::make('data_languages.en.name')
                                    ->label('Name'),
                                Forms\Components\TextInput::make('data_languages.en.position')
                                    ->label('Position'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.color')
                    ->label('Цвет заголовка')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
                ...$this->spacingSelectFields()
            ],

            'info_block' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.ru.content')
                                    ->label('Текст')
                                    ->required()
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.en.content')
                                    ->label('Text')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'checkmark',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.style')
                    ->label('Стиль')
                    ->options([
                        'blue' => 'Синий фон (белый текст)',
                        'light' => 'Светлый фон',
                        'accent' => 'Голубая полоска слева',
                        'dark' => 'Тёмный фон (белый текст)',
                        'bordered' => 'Белый фон с границей',
                    ])
                    ->default('light'),
                ...$this->textColorSelectFields('data_languages.text_color', 'Цвет текста'),
                ...$this->textColorSelectFields('data_languages.link_color', 'Цвет ссылок'),
                Forms\Components\Select::make('data_languages.text_size')
                    ->label('Размер текста')
                    ->options([
                        'small' => 'Мелкий',
                        'normal' => 'Обычный',
                        'large' => 'Крупный',
                    ])
                    ->default('normal'),
                ...$this->spacingSelectFields(),
            ],

            'divider' => [
                Forms\Components\Select::make('data_languages.style')
                    ->label('Стиль')
                    ->options([
                        'line' => 'Тонкая линия',
                        'thick' => 'Толстая линия',
                        'space' => 'Только отступ',
                        'dots' => 'Точки',
                    ])
                    ->default('line'),
                ...$this->spacingSelectFields()
            ],

            'timeline' => [
//                Forms\Components\TextInput::make('data_languages.title')
//                    ->label('Заголовок таймлайна'),
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.ru.events')
                                    ->label('События')
                                    ->schema([
                                        Forms\Components\TextInput::make('year')
                                            ->label('Год / дата'),
                                        Forms\Components\Textarea::make('title')
                                            ->label('Заголовок')
                                            ->rows(2),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Описание'),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.en.events')
                                    ->label('Events')
                                    ->schema([
                                        Forms\Components\TextInput::make('year')
                                            ->label('Year / date'),
                                        Forms\Components\Textarea::make('title')
                                            ->label('Title')
                                            ->rows(2),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Description'),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                ...$this->textColorSelectFields('data_languages.year_color', 'Цвет года'),
                ...$this->textColorSelectFields('data_languages.title_color', 'Цвет заголовков'),
                ...$this->textColorSelectFields('data_languages.text_color', 'Цвет текста'),
                ...$this->spacingSelectFields(),
            ],

            'numbered_steps' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
//                                Forms\Components\TextInput::make('data_languages.ru.title')
//                                    ->label('Заголовок'),
                                Forms\Components\Repeater::make('data_languages.ru.steps')
                                    ->label('Шаги')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок шага'),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Описание'),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
//                                Forms\Components\TextInput::make('data_languages.en.title')
//                                    ->label('Title'),
                                Forms\Components\Repeater::make('data_languages.en.steps')
                                    ->label('Steps')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Step title'),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Description'),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.icon_style')
                    ->label('Стиль иконки')
                    ->options([
                        'numbers' => 'Цифры (01, 02...)',
                        'checkmarks' => 'Галочки ✓',
                        'dots' => 'Точки ●',
                        'none' => 'Без иконки',
                    ])
                    ->default('numbers'),
                Forms\Components\Select::make('data_languages.align')
                    ->label('Выравнивание')
                    ->options([
                        'left' => 'По левому краю',
                        'center' => 'По центру',
                    ])
                    ->default('left'),
                Forms\Components\Toggle::make('data_languages.connected')
                    ->label('Соединять линией')
                    ->default(false),
                ...$this->textColorSelectFields('data_languages.title_color', 'Цвет заголовков'),
                ...$this->textColorSelectFields('data_languages.text_color', 'Цвет текста'),
                ...$this->textColorSelectFields('data_languages.bg_color', 'Цвет фона', true),
               ...$this->spacingSelectFields()
            ],

            'cards_grid' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.ru.cards')
                                    ->label('Карточки')
                                    ->schema([
                                        Forms\Components\FileUpload::make('icon')
                                            ->label('Иконка / изображение')
                                            ->image()
                                            ->directory('report-images'),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Textarea::make('text')
                                            ->label('Текст'),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.en.cards')
                                    ->label('Cards')
                                    ->schema([
                                        Forms\Components\FileUpload::make('icon')
                                            ->label('Icon / Image')
                                            ->image()
                                            ->directory('report-images'),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Title'),
                                        Forms\Components\Textarea::make('text')
                                            ->label('Text'),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.columns')
                    ->label('Колонок в ряду')
                    ->options([
                        '2' => '2 колонки',
                        '3' => '3 колонки',
                        '4' => '4 колонки',
                    ])
                    ->default('3'),
                ...$this->textColorSelectFields('data_languages.color_title', 'Цвет заголовка'),
                Forms\Components\Select::make('data_languages.title_size')
                    ->label('Размер заголовка')
                    ->options([
                        'small' => 'Маленький',
                        'normal' => 'Обычный',
                        'large' => 'Крупный',
                    ])
                    ->default('normal'),
                Forms\Components\Select::make('data_languages.logo_size')
                    ->label('Размер логотипа')
                    ->options([
                        'small' => 'Маленький (48px)',
                        'normal' => 'Обычный (64px)',
                        'large' => 'Большой (80px)',
                        'xlarge' => 'Очень большой (96px)',
                    ])
                    ->default('normal'),
                ...$this->spacingSelectFields()
            ],

            'icon_list' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.ru.items')
                                    ->label('Пункты')
                                    ->schema([
                                        Forms\Components\FileUpload::make('icon')
                                            ->label('Иконка (PNG/SVG)')
                                            ->image()
                                            ->directory('report-images'),
                                        Forms\Components\RichEditor::make('title')
                                            ->label('Заголовок')
                                            ->formatStateUsing(function ($state) {
                                                if (is_string($state) && ! str_contains($state, '<')) {
                                                    return '<p>' . $state . '</p>';
                                                }

                                                return $state;
                                            })
                                            ->plugins([
                                                TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                            ])
                                            ->enableToolbarButtons([
                                                'tooltip',
                                        'checkmark',
                                                'removeTooltip',
                                            ])
                                            ->columnSpanFull(),
                                        Forms\Components\RichEditor::make('text')
                                            ->label('Описание')
                                            ->plugins([
                                                TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                            ])
                                            ->enableToolbarButtons([
                                                'tooltip',
                                        'checkmark',
                                                'removeTooltip',
                                            ])
                                            ->columnSpanFull(),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\Repeater::make('data_languages.en.items')
                                    ->label('Items')
                                    ->schema([
                                        Forms\Components\FileUpload::make('icon')
                                            ->label('Icon (PNG/SVG)')
                                            ->image()
                                            ->directory('report-images'),
                                        Forms\Components\RichEditor::make('title')
                                            ->label('Title')
                                            ->plugins([
                                                TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                            ])
                                            ->enableToolbarButtons([
                                                'tooltip',
                                        'checkmark',
                                                'removeTooltip',
                                            ])
                                            ->formatStateUsing(function ($state) {
                                                if (is_string($state) && ! str_contains($state, '<')) {
                                                    return '<p>' . $state . '</p>';
                                                }

                                                return $state;
                                            })
                                            ->columnSpanFull(),
                                        Forms\Components\RichEditor::make('text')
                                            ->label('Description')
                                            ->plugins([
                                                TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                            ])
                                            ->enableToolbarButtons([
                                                'tooltip',
                                        'checkmark',
                                                'removeTooltip',
                                            ])
                                            ->columnSpanFull(),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.icon_size')
                    ->label('Размер иконок')
                    ->options([
                        'small' => 'Маленький (24px)',
                        'medium' => 'Средний (40px)',
                        'large' => 'Большой (60px)',
                    ])
                    ->default('medium'),
                Forms\Components\Select::make('data_languages.color')
                    ->label('Цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
//                Forms\Components\Select::make('data_languages.title_style')
//                    ->label('Стиль заголовка')
//                    ->options([
//                        'large_bold' => 'Крупный жирный',
//                        'normal' => 'Обычный',
//                        'small' => 'Маленький',
//                        'accent' => 'Акцентный (цветной)',
//                        'muted' => 'Приглушённый',
//                    ])
//                    ->default('large_bold'),
                ...$this->textColorSelectFields('data_languages.text_color', 'Цвет текста'),
                ...$this->spacingSelectFields()

            ],

            'chart' => [
                Forms\Components\Select::make('data_languages.chart_type')
                    ->label('Тип графика')
                    ->options([
                        'lollipop' => 'Палочки с точками (Lollipop)',
                        'bar' => 'Столбчатая диаграмма',
                        'bar_horizontal' => 'Горизонтальная столбчатая',
                        'line' => 'Линейный график',
                    ])
                    ->default('lollipop')
                    ->live()
                    ->required(),
                Forms\Components\Toggle::make('data_languages.lollipop_line_overlay')
                    ->label('Отображать "Значение 2" как линию (поверх столбцов)')
                    ->visible(fn ($get) => $get('data_languages.chart_type') === 'lollipop')
                    ->default(false),
                Forms\Components\Toggle::make('data_languages.animate')
                    ->label('Анимация при скролле')
                    ->default(true),
                Forms\Components\Select::make('data_languages.color_scheme')
                    ->label('Цвет линий / столбцов / точек')
                    ->options([
                        'blue' => 'Синий (#005B9C → #5BA4D9)',
                        'dark_blue' => 'Тёмно-синий (#00355A → #005B9C)',
                        'cyan' => 'Бирюзовый (#00838F → #00BCD4)',
                        'teal' => 'Зелёно-синий (#009688 → #4DB6AC)',
                        'light_blue' => 'Голубой (#4FC3F7 → #B3E5FC)',
                        'grey' => 'Серый (#6B7785 → #CDD6DE)',
                    ])
                    ->default('blue'),
                Forms\Components\Select::make('data_languages.chart_size')
                    ->label('Масштаб (высота графика)')
                    ->options([
                        'compact' => 'Компактный (140px)',
                        'small' => 'Маленький (180px)',
                        'medium' => 'Средний (220px)',
                        'large' => 'Большой (280px)',
                        'xl' => 'Очень большой (340px)',
                    ])
                    ->default('medium'),
                Forms\Components\Select::make('data_languages.chart_width')
                    ->label('Ширина блока')
                    ->options([
                        '100' => 'Полная ширина (100%)',
                        '75' => 'Три четверти (75%)',
                        '66' => 'Две трети (66%)',
                        '50' => 'Половина (50%)',
                        '33' => 'Треть (33%)',
                    ])
                    ->default('100'),
                Forms\Components\Toggle::make('data_languages.prevent_merge')
                    ->label('Начинать с новой строки')
                    ->helperText('Не объединять с соседними блоками')
                    ->default(false),
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.ru.title')
                                    ->label('Заголовок')
                                    ->placeholder('Консолидированные активы,')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'bold', 'italic', 'tooltip',
                                        'checkmark', 'removeTooltip', 'superscript'
                                    ]),
                                Forms\Components\RichEditor::make('data_languages.ru.unit')
                                    ->label('Подзаголовок / единицы')
                                    ->placeholder('тыс. шт. / млрд руб. / чел.')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'bold', 'italic', 'tooltip',
                                        'checkmark', 'removeTooltip', 'superscript'
                                    ]),
                                Forms\Components\Repeater::make('data_languages.ru.values')
                                    ->label('Значения')
                                    ->schema([
                                        Forms\Components\TextInput::make('label')
                                            ->label('Период / название')
                                            ->placeholder('2023 / Экономика')
                                            ->required(),
                                        Forms\Components\TextInput::make('value')
                                            ->label('Значение 1')
                                            ->placeholder('406.1')
                                            ->required(),
                                        Forms\Components\TextInput::make('value2')
                                            ->label('Значение 2 (необяз.)')
                                            ->placeholder('250.3'),
                                        Forms\Components\TextInput::make('value3')
                                            ->label('Значение 3 (необяз.)')
                                            ->placeholder('180.0'),
                                        Forms\Components\Select::make('accent_color')
                                            ->label('Акцентный цвет')
                                            ->options([
                                                '' => 'По умолчанию',
                                                'dark_blue' => 'Тёмно-синий (#00355A)',
                                                'blue' => 'Синий (#005B9C)',
                                                'cyan' => 'Бирюзовый (#00BCD4)',
                                                'teal' => 'Зелёно-синий (#009688)',
                                                'orange' => 'Оранжевый (#FF8F00)',
                                                'green' => 'Зелёный (#43A047)',
                                                'red' => 'Красный (#E53935)',
                                            ])
                                            ->default(''),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.en.title')
                                    ->label('Title')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'bold', 'italic', 'tooltip',
                                        'checkmark', 'removeTooltip', 'superscript'
                                    ]),
                                Forms\Components\RichEditor::make('data_languages.en.unit')
                                    ->label('Subtitle / unit')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'bold', 'italic', 'tooltip',
                                        'checkmark', 'removeTooltip', 'superscript'
                                    ]),
                                Forms\Components\Repeater::make('data_languages.en.values')
                                    ->label('Values')
                                    ->schema([
                                        Forms\Components\TextInput::make('label')
                                            ->label('Period / name'),
                                        Forms\Components\TextInput::make('value')
                                            ->label('Value 1'),
                                        Forms\Components\TextInput::make('value2')
                                            ->label('Value 2 (optional)'),
                                        Forms\Components\TextInput::make('value3')
                                            ->label('Value 3 (optional)'),
                                        Forms\Components\Select::make('accent_color')
                                            ->label('Accent color')
                                            ->options([
                                                '' => 'Default',
                                                'dark_blue' => 'Dark blue',
                                                'blue' => 'Blue',
                                                'cyan' => 'Cyan',
                                                'teal' => 'Teal',
                                                'orange' => 'Orange',
                                                'green' => 'Green',
                                                'red' => 'Red',
                                            ])
                                            ->default(''),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('data_languages.legend')
                    ->label('Легенда (необязательно)')
                    ->helperText('Каждый пункт привязан к серии данных (Значение 1/2/3). Цвет пункта = цвет столбцов/точек этой серии.')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->label('Название серии')
                            ->placeholder('Охрана водных ресурсов')
                            ->required(),
                        Forms\Components\Select::make('series')
                            ->label('Привязка к значению')
                            ->options([
                                'value' => 'Значение 1 (основное)',
                                'value2' => 'Значение 2',
                                'value3' => 'Значение 3',
                            ])
                            ->default('value')
                            ->required(),
                        Forms\Components\Select::make('color')
                            ->label('Цвет серии')
                            ->options([
                                '#005B9C' => 'Синий (#005B9C)',
                                '#5BA4D9' => 'Голубой (#5BA4D9)',
                                '#B8D4EA' => 'Светло-голубой (#B8D4EA)',
                                '#00355A' => 'Тёмно-синий (#00355A)',
                                '#4FC3F7' => 'Светло-синий (#4FC3F7)',
                                '#00BCD4' => 'Бирюзовый (#00BCD4)',
                                '#4DB6AC' => 'Зелёно-синий (#4DB6AC)',
                                '#CDD6DE' => 'Серый (#CDD6DE)',
                                '#6B7785' => 'Тёмно-серый (#6B7785)',
                            ])
                            ->default('#005B9C'),
                    ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->columnSpanFull()
                    ->collapsible(),
                ...$this->spacingSelectFields(),
            ],

            'donut_chart' => [
                Forms\Components\Select::make('data_languages.donut_style')
                    ->label('Стиль диаграммы')
                    ->options([
                        'simple' => 'Простая (одно значение)',
                        'multi' => 'Многосегментная',
                    ])
                    ->default('simple')
                    ->required()
                    ->live(),
                Forms\Components\Toggle::make('data_languages.animate')
                    ->label('Анимация при скролле')
                    ->default(true),
                Forms\Components\Select::make('data_languages.donut_size')
                    ->label('Размер круга')
                    ->options([
                        'xs' => 'Очень маленький (80px)',
                        'sm' => 'Маленький (120px)',
                        'md' => 'Средний (160px)',
                        'lg' => 'Большой (200px)',
                        'xl' => 'Очень большой (250px)',
                    ])
                    ->default('md'),
                Forms\Components\Select::make('data_languages.donut_width')
                    ->label('Ширина блока')
                    ->options([
                        '100' => 'Полная ширина (100%)',
                        '75' => 'Три четверти (75%)',
                        '66' => 'Две трети (66%)',
                        '50' => 'Половина (50%)',
                        '33' => 'Треть (33%)',
                    ])
                    ->default('100'),
                Forms\Components\Toggle::make('data_languages.prevent_merge')
                    ->label('Начинать с новой строки')
                    ->helperText('Не объединять с соседними блоками')
                    ->default(false),
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.ru.title')
                                    ->label('Заголовок')
                                    ->placeholder('Консолидированные активы,')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'bold', 'italic', 'tooltip',
                                        'checkmark', 'removeTooltip', 'superscript'
                                    ]),
                                Forms\Components\RichEditor::make('data_languages.ru.unit')
                                    ->label('Подзаголовок / единицы')
                                    ->placeholder('млрд руб.')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'bold', 'italic', 'tooltip',
                                        'checkmark', 'removeTooltip', 'superscript'
                                    ]),

                                // --- Simple donut fields ---
                                Forms\Components\TextInput::make('data_languages.ru.value')
                                    ->label('Значение (%)')
                                    ->placeholder('80')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'simple'),
                                Forms\Components\TextInput::make('data_languages.ru.prefix')
                                    ->label('Префикс (перед числом)')
                                    ->placeholder('~')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'simple'),
                                Forms\Components\TextInput::make('data_languages.ru.suffix')
                                    ->label('Суффикс (после числа)')
                                    ->placeholder('%')
                                    ->default('%')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'simple'),
                                Forms\Components\TextInput::make('data_languages.ru.description')
                                    ->label('Описание')
                                    ->placeholder('электроэнергии передаётся по сетям Группы')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'simple'),

                                // --- Multi donut fields ---
                                Forms\Components\TextInput::make('data_languages.ru.center_value')
                                    ->label('Центральное значение')
                                    ->placeholder('725')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'multi'),
                                Forms\Components\TextInput::make('data_languages.ru.center_label')
                                    ->label('Подпись центра')
                                    ->placeholder('млрд руб.')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'multi'),
                                Forms\Components\Repeater::make('data_languages.ru.segments')
                                    ->label('Сегменты')
                                    ->schema($this->donutSegmentFields('ru'))
                                    ->columns(3)
                                    ->defaultItems(3)
                                    ->columnSpanFull()
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'multi'),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.en.title')
                                    ->label('Title')
                                    ->placeholder('Consolidated assets,')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'bold', 'italic', 'tooltip',
                                        'checkmark', 'removeTooltip', 'superscript'
                                    ]),
                                Forms\Components\RichEditor::make('data_languages.en.unit')
                                    ->label('Subtitle / units')
                                    ->placeholder('bn RUB')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                        CheckmarkRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'bold', 'italic', 'tooltip',
                                        'checkmark', 'removeTooltip', 'superscript'
                                    ]),

                                // --- Simple donut fields ---
                                Forms\Components\TextInput::make('data_languages.en.value')
                                    ->label('Value (%)')
                                    ->placeholder('80')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'simple'),
                                Forms\Components\TextInput::make('data_languages.en.prefix')
                                    ->label('Prefix (before number)')
                                    ->placeholder('~')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'simple'),
                                Forms\Components\TextInput::make('data_languages.en.suffix')
                                    ->label('Suffix (after number)')
                                    ->placeholder('%')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'simple'),
                                Forms\Components\TextInput::make('data_languages.en.description')
                                    ->label('Description')
                                    ->placeholder('of electricity is transmitted via the Group grids')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'simple'),

                                // --- Multi donut fields ---
                                Forms\Components\TextInput::make('data_languages.en.center_value')
                                    ->label('Center value')
                                    ->placeholder('725')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'multi'),
                                Forms\Components\TextInput::make('data_languages.en.center_label')
                                    ->label('Center label')
                                    ->placeholder('bn RUB')
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'multi'),
                                Forms\Components\Repeater::make('data_languages.en.segments')
                                    ->label('Segments')
                                    ->schema($this->donutSegmentFields('en'))
                                    ->columns(3)
                                    ->defaultItems(3)
                                    ->columnSpanFull()
                                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'multi'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.center_text_size')
                    ->label('Размер текста в центре')
                    ->options([
                        'auto' => 'Авто (по размеру круга)',
                        'md' => 'Средний (24px)',
                        'lg' => 'Большой (32px)',
                        'xl' => 'Очень большой (40px)',
                        '2xl' => 'Крупный (48px)',
                        '3xl' => 'Максимальный (60px)',
                    ])
                    ->default('auto')
                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'simple'),
                ...$this->textColorSelectFields('data_languages.ring_color', 'Цвет кольца'),

                Forms\Components\FileUpload::make('data_languages.center_image')
                    ->label('Иконка в центре (вместо текста)')
                    ->helperText('Если загружена — при наведении на сегмент скрывается, показывая значение')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'])
                    ->directory('donut-icons')
                    ->visible(fn (Get $get) => ($get('data_languages.donut_style') ?? 'simple') === 'multi'),

                ...$this->spacingSelectFields(),
            ],

            'custom_html' => [
                Forms\Components\Select::make('data_languages.html_width')
                    ->label('Ширина блока')
                    ->options([
                        '100' => 'Полная ширина (100%)',
                        '75' => 'Три четверти (75%)',
                        '66' => 'Две трети (66%)',
                        '50' => 'Половина (50%)',
                        '33' => 'Треть (33%)',
                    ])
                    ->default('100'),
                Forms\Components\Toggle::make('data_languages.prevent_merge')
                    ->label('Начинать с новой строки')
                    ->helperText('Не объединять с соседними блоками')
                    ->default(false),
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\Textarea::make('data_languages.ru.html_content')
                                    ->label('HTML-код')
                                    ->rows(15)
                                    ->columnSpanFull()
                                    ->placeholder('<div class="my-block">...</div>'),
                                Forms\Components\Textarea::make('data_languages.ru.css_content')
                                    ->label('CSS-стили (опционально)')
                                    ->rows(8)
                                    ->columnSpanFull()
                                    ->placeholder('.my-block { display: flex; ... }'),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\Textarea::make('data_languages.en.html_content')
                                    ->label('HTML code')
                                    ->rows(15)
                                    ->columnSpanFull()
                                    ->placeholder('<div class="my-block">...</div>'),
                                Forms\Components\Textarea::make('data_languages.en.css_content')
                                    ->label('CSS styles (optional)')
                                    ->rows(8)
                                    ->columnSpanFull()
                                    ->placeholder('.my-block { display: flex; ... }'),
                            ]),
                    ])
                    ->columnSpanFull(),
                ...$this->spacingSelectFields(),
            ],

            'custom_html_native' => [
                Forms\Components\Select::make('data_languages.html_width')
                    ->label('Ширина блока')
                    ->options([
                        '100' => 'Полная ширина (100%)',
                        '75' => 'Три четверти (75%)',
                        '66' => 'Две трети (66%)',
                        '50' => 'Половина (50%)',
                        '33' => 'Треть (33%)',
                    ])
                    ->default('100'),
                Forms\Components\Toggle::make('data_languages.prevent_merge')
                    ->label('Начинать с новой строки')
                    ->helperText('Не объединять с соседними блоками')
                    ->default(false),
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\Textarea::make('data_languages.ru.html_content')
                                    ->label('HTML-код (включая <script>)')
                                    ->rows(15)
                                    ->columnSpanFull()
                                    ->placeholder('<div class="my-block">...</div>\n<script>...</script>'),
                                Forms\Components\Textarea::make('data_languages.ru.css_content')
                                    ->label('CSS-стили (опционально)')
                                    ->rows(8)
                                    ->columnSpanFull()
                                    ->placeholder('.my-block { display: flex; ... }'),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\Textarea::make('data_languages.en.html_content')
                                    ->label('HTML code (including <script>)')
                                    ->rows(15)
                                    ->columnSpanFull()
                                    ->placeholder('<div class="my-block">...</div>\n<script>...</script>'),
                                Forms\Components\Textarea::make('data_languages.en.css_content')
                                    ->label('CSS styles (optional)')
                                    ->rows(8)
                                    ->columnSpanFull()
                                    ->placeholder('.my-block { display: flex; ... }'),
                            ]),
                    ])
                    ->columnSpanFull(),
                ...$this->spacingSelectFields(),
            ],

            'custom_component' => [
                Forms\Components\Select::make('data_languages.component_name')
                    ->label('Компонент')
                    ->required()
                    ->options($this->getAvailableComponents())
                    ->searchable()
                    ->helperText('Создайте компонент через: php artisan make:component CustomPageBlocks/TestComponent'),
                Forms\Components\Textarea::make('data_languages.component_data')
                    ->label('Данные компонента (JSON)')
                    ->rows(10)
                    ->columnSpanFull()
                    ->helperText('Передайте данные в компонент в формате JSON. Например: {"title": "Привет", "items": ["a", "b"]}'),
                Forms\Components\Select::make('data_languages.html_width')
                    ->label('Ширина блока')
                    ->options([
                        '100' => 'Полная ширина (100%)',
                        '75' => 'Три четверти (75%)',
                        '66' => 'Две трети (66%)',
                        '50' => 'Половина (50%)',
                        '33' => 'Треть (33%)',
                    ])
                    ->default('100'),
                Forms\Components\Toggle::make('data_languages.prevent_merge')
                    ->label('Начинать с новой строки')
                    ->helperText('Не объединять с соседними блоками')
                    ->default(false),
                ...$this->spacingSelectFields(),
            ],

            default => [
                Forms\Components\Placeholder::make('info')
                    ->label('Выберите тип блока')
                    ->content('Пожалуйста, выберите тип блока выше, чтобы увидеть доступные поля.'),
            ],
        };
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('type')
                    ->label('Тип')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => match($state) {
//                        'text-with-title' => 'Текст с заголовком',
                        'rich_text' => 'Текстовый блок',
                        'image' => 'Изображение',
                        'two_columns' => 'Текст в две колонки',
                        'stats_grid' => 'Сетка показателей',
                        'quote' => 'Цитата',
                        'heading' => 'Заголовок',
                        'gri_reference' => 'GRI ссылка',
                        'image_row' => 'Изображения в ряд',
                        'table' => 'Таблица',
                        'key_figure' => 'Ключевая цифра',
                        'subtitle' => 'Подзаголовок',
                        'person_card' => 'Карточка сотрудника',
                        'info_block' => 'Информационный блок',
                        'divider' => 'Разделитель',
                        'timeline' => 'Таймлайн',
                        'numbered_steps' => 'Нумерованные шаги',
                        'cards_grid' => 'Сетка карточек',
                        'icon_list' => 'Перечисление с иконками',
                        'chart' => 'Диаграмма / График',
                        'donut_chart' => 'Круговая диаграмма',
                        'custom_html' => 'Custom HTML',
                        'custom_html_native' => 'Custom HTML (native)',
                        'custom_component' => 'Кастомный компонент',
                        default => $state,
                    }),
                TextColumn::make('preview')
                    ->label('Содержание')
                    ->state(function ($record): string {
                        $data_languages = $record->data_languages['ru'] ?? [];
                        if (!is_array($data_languages)) return '';

                        $content = match($record->type) {
                            'heading' => $data_languages['content'] ?? '',
                            'subtitle' => $data_languages['text'] ?? '',
                            'text-with-title' => $data_languages['title'] ?? '',
                            'rich_text' => strip_tags($data_languages['content'] ?? ''),
                            'quote' => $data_languages['text'] ?? '',
                            'key_figure' => $data_languages['value'] ?? '',
                            'person_card' => $data_languages['name'] ?? '',
                            'info_block' => strip_tags($data_languages['content'] ?? ''),
                            'timeline' => $data_languages['title'] ?? '',
                            'numbered_steps' => $data_languages['title'] ?? '',
                            'gri_reference' => $data_languages['codes'] ?? '',
                            'stats_grid' => ($data_languages['items'][0]['description'] ?? $data_languages['items'][0]['title'] ?? ''),
                            'cards_grid' => ($data_languages['cards'][0]['title'] ?? ''),
                            'icon_list' => (isset($data_languages['items'][0]) && is_array($data_languages['items'][0])) ? strip_tags($data_languages['items'][0]['title'] ?? '') : '',
                            'table' => ($data_languages['headers'][0]['text'] ?? ''),
                            'image' => '',
                            'image_row' => '',
                            'two_columns' => strip_tags($data_languages['left'] ?? ''),
                            'chart' => ($data_languages['title'] ?? '') . ' (' . ($record->data_languages['chart_type'] ?? 'lollipop') . ')',
                            'donut_chart' => ($record->data_languages['donut_style'] ?? 'simple') === 'multi' ? ($record->data_languages['center_value'] ?? '') : ($record->data_languages['value'] ?? '') . ($record->data_languages['suffix'] ?? '%'),
                            'custom_component' => $data_languages['component_name'] ?? '',
                            'custom_html' => strip_tags($data_languages['html_content'] ?? ''),
                            'custom_html_native' => strip_tags($data_languages['html_content'] ?? ''),
                            default => '',
                        };

                        // Для изображений добавляем HTML превью
                        if ($record->type === 'image' && !empty($data_languages['url'])) {
                            $url = str_starts_with($data_languages['url'], 'http') ? $data_languages['url'] : asset('storage/' . $data_languages['url']);
                            return '<img src="' . $url . '" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; max-width: 40px; max-height: 40px;">';
                        }
                        if ($record->type === 'image_row' && !empty($data_languages['images'][0]['url'])) {
                            $url = str_starts_with($data_languages['images'][0]['url'], 'http') ? $data_languages['images'][0]['url'] : asset('storage/' . $data_languages['images'][0]['url']);
                            return '<img src="' . $url . '" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; max-width: 40px; max-height: 40px;">';
                        }

                        return e(Str::limit(trim($content), 50));
                    })
                    ->html()
                    ->limit(50),
                TextColumn::make('items_count')
                    ->label('Элементов')
                    ->formatStateUsing(function ($state, $record): string {
                        $data_languages = is_array($state) ? $state : [];
                        if (isset($data_languages['items']) && is_array($data_languages['items'])) return count($data_languages['items']);
                        if (isset($data_languages['events']) && is_array($data_languages['events'])) return count($data_languages['events']);
                        if (isset($data_languages['steps']) && is_array($data_languages['steps'])) return count($data_languages['steps']);
                        if (isset($data_languages['cards']) && is_array($data_languages['cards'])) return count($data_languages['cards']);
                        if (isset($data_languages['images']) && is_array($data_languages['images'])) return count($data_languages['images']);
                        if (isset($data_languages['headers']) && is_array($data_languages['headers'])) return count($data_languages['headers']);
                        if (isset($data_languages['rows']) && is_array($data_languages['rows'])) return count($data_languages['rows']);
                        if (isset($data_languages['values']) && is_array($data_languages['values'])) return count($data_languages['values']);
                        if (isset($data_languages['segments']) && is_array($data_languages['segments'])) return count($data_languages['segments']);
                        return '';
                    })
                    ->visible(fn ($record): bool => $record ? in_array($record->type, ['stats_grid', 'timeline', 'numbered_steps', 'cards_grid', 'image_row', 'table', 'icon_list', 'chart', 'donut_chart']) : false),
                TextColumn::make('sort')
                    ->label('Сортировка')
                    ->sortable(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('type')
                    ->label('Тип блока')
                    ->options([
                        'heading' => 'Заголовок',
                        'image' => 'Изображение',
                        'subtitle' => 'Подзаголовок',
                        'divider' => 'Разделитель',
//                        'text-with-title' => 'Текст с заголовком',
                        'rich_text' => 'Текстовый блок',
                        'two_columns' => 'Текст в две колонки',
                        'table' => 'Таблица',
                        'timeline' => 'Таймлайн',
                        'stats_grid' => 'Сетка показателей',
                        'quote' => 'Цитата',
                        'gri_reference' => 'GRI ссылка',
                        'image_row' => 'Изображения в ряд',
                        'key_figure' => 'Ключевая цифра',
                        'person_card' => 'Карточка сотрудника',
                        'info_block' => 'Информационный блок',
                        'numbered_steps' => 'Нумерованные шаги',
                        'cards_grid' => 'Сетка карточек',
                        'icon_list' => 'Перечисление с иконками',
                        'chart' => 'Диаграмма / График',
                        'donut_chart' => 'Круговая диаграмма',
                        'custom_html' => 'Custom HTML',
                        'custom_html_native' => 'Custom HTML (native)',
                        'custom_component' => 'Кастомный компонент',
                    ]),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private function donutSegmentFields(string $locale): array
    {
        $ru = $locale === 'ru';

        return [
            Forms\Components\TextInput::make('label')
                ->label($ru ? 'Название' : 'Label')
                ->required($ru),
            Forms\Components\TextInput::make('value')
                ->label($ru ? 'Значение' : 'Value')
                ->required($ru),
            Forms\Components\Select::make('color')
                ->label($ru ? 'Цвет' : 'Color')
                ->options([
                    '#00355A' => 'Тёмно-синий (#00355A)',
                    '#005B9C' => 'Синий (#005B9C)',
                    '#2196F3' => 'Голубой (#2196F3)',
                    '#4FC3F7' => 'Светло-голубой (#4FC3F7)',
                    '#B3E5FC' => 'Очень светлый (#B3E5FC)',
                    '#00BCD4' => 'Бирюзовый (#00BCD4)',
                    '#009688' => 'Зелёно-синий (#009688)',
                    '#80CBC4' => 'Мятный (#80CBC4)',
                    '#CDD6DE' => 'Серый (#CDD6DE)',
                    '#6B7785' => 'Тёмно-серый (#6B7785)',
                ])
                ->default('#2196F3'),
            Forms\Components\TextInput::make('tooltip_label')
                ->label($ru ? 'Тултип к названию' : 'Label tooltip')
                ->placeholder($ru ? 'Пояснение к названию сегмента' : 'Explanation for the segment label')
                ->helperText($ru ? 'Появится при наведении на название' : 'Shown on label hover'),
            Forms\Components\TextInput::make('tooltip_value')
                ->label($ru ? 'Тултип к значению' : 'Value tooltip')
                ->placeholder($ru ? 'Пояснение к значению' : 'Explanation for the value')
                ->helperText($ru ? 'Появится при наведении на значение' : 'Shown on value hover'),
        ];
    }

    private function textColorSelectFields($column, $label='Цвет текста', $isBg=false): array
    {
        $prefix = $isBg ? 'bg-' : 'text-';
        $textColorOptions = [
            $prefix . 'blue-600' => 'Тёмно-синий',
            $prefix . 'blue-500' => 'Синий',
            $prefix . 'blue-400' => 'Голубой',
            $prefix . 'black-500' => 'Чёрный',
            $prefix . 'white' => 'Белый',
            $prefix . 'grey' => 'Серый',
        ];

        return [
            Forms\Components\Select::make($column)
                ->label($label)
                ->required()
                ->options($textColorOptions)
                ->default('text-blue-600'),
        ];
    }

    private function spacingSelectFields(): array
    {
        $spacingOptions = [
            'none' => 'Без отступа',
            'small' => 'Маленький (8px)',
            'normal' => 'Обычный (16px)',
            'large' => 'Большой (32px)',
            'xl' => 'Очень большой (48px)',
            '2xl' => 'Огромный (64px)',
            '3xl' => 'Максимальный (96px)',
        ];

        return [
            Forms\Components\Select::make('data_languages.spacing_top')
                ->label('Отступ сверху')
                ->options($spacingOptions)
                ->default('none'),
            Forms\Components\Select::make('data_languages.spacing_bottom')
                ->label('Отступ снизу')
                ->options($spacingOptions)
                ->default('xl'),
        ];
    }

    private function getAvailableComponents(): array
    {
        $components = [];

        // Сканируем только папку app/View/Components/CustomPageBlocks
        $customPageBlocksPath = app_path('View/Components/CustomPageBlocks');
        if (is_dir($customPageBlocksPath)) {
            $files = scandir($customPageBlocksPath);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    $className = pathinfo($file, PATHINFO_FILENAME);
                    $kebabName = Str::kebab($className);
                    $components[$kebabName] = $kebabName;
                }
            }
        }

        return $components;
    }
}
