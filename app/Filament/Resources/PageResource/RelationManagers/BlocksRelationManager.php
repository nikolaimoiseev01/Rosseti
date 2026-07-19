<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use App\Filament\RichContent\TooltipRichContentPlugin;
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

class BlocksRelationManager extends RelationManager
{
    protected static string $relationship = 'blocks';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Тип блока')
                    ->required()
                    ->options([
                        'heading' => 'Заголовок',
                        'image' => 'Изображение',
                        'subtitle' => 'Подзаголовок',
                        'divider' => 'Разделитель',
                        'text-with-title' => 'Текст с заголовком',
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
                    ])
                    ->live(),

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
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
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
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ],

            'rich_text' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.ru.content')
                                    ->label('Содержимое')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'removeTooltip',
                                    ])
                                    ->required()
                                    ->columnSpanFull()
                                    ->default('')
                                    ->fileAttachmentsVisibility('public'),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.en.content')
                                    ->label('Content')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
                                        'removeTooltip',
                                    ])
                                    ->columnSpanFull()
                                    ->default('')
                                    ->fileAttachmentsVisibility('public'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.text_color')
                    ->label('Цвет текста')
                    ->options([
                        'default' => 'Чёрный (по умолчанию)',
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                        'muted' => 'Серый',
                        'white' => 'Белый (для тёмных фонов)',
                    ])
                    ->default('default'),
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
                                    ->directory('report-images'),
                                Forms\Components\TextInput::make('data_languages.en.caption')
                                    ->label('Image caption'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.size')
                    ->label('Размер')
                    ->options([
                        'full' => 'На всю ширину',
                        'large' => 'Большое (75%)',
                        'medium' => 'Среднее (50%)',
                    ])
                    ->default('full'),
            ],

            'two_columns' => [
                Forms\Components\RichEditor::make('data_languages.left')
                    ->label('Левая колонка')
                    ->plugins([
                        TooltipRichContentPlugin::make(),
                    ])
                    ->enableToolbarButtons([
                        'tooltip',
                        'removeTooltip',
                    ])
                    ->required(),
                Forms\Components\RichEditor::make('data_languages.right')
                    ->label('Правая колонка')
                    ->plugins([
                        TooltipRichContentPlugin::make(),
                    ])
                    ->enableToolbarButtons([
                        'tooltip',
                        'removeTooltip',
                    ])
                    ->required(),
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
                                            ->label('Value')
                                            ->required(),
                                        Forms\Components\TextInput::make('unit')
                                            ->label('Unit'),
                                        Forms\Components\TextInput::make('description')
                                            ->label('Description')
                                            ->required(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
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
            ],

            'heading' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.ru.content')
                                    ->label('Текст заголовка')
                                    ->required(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.en.content')
                                    ->label('Heading text'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.level')
                    ->label('Уровень')
                    ->options([
                        'h1' => 'H1 — Главный',
                        'h2' => 'H2 — Крупный',
                        'h3' => 'H3 — Средний',
                        'h4' => 'H4 — Маленький',
                    ])
                    ->default('h2'),
                Forms\Components\Select::make('data_languages.color')
                    ->label('Цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                        'dark' => 'Чёрный',
                        'white' => 'Белый (для тёмных фонов)',
                    ])
                    ->default('primary'),
                ...$this->spacingSelectFields(),
            ],

            'gri_reference' => [
                Forms\Components\TextInput::make('data_languages.codes')
                    ->label('Коды GRI')
                    ->helperText('Например: GRI 2-1, 2-6')
                    ->required(),
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
            ],

            'table' => [
                Forms\Components\TextInput::make('data_languages.caption')
                    ->label('Заголовок таблицы'),
                Forms\Components\Select::make('data_languages.header_style')
                    ->label('Стиль заголовков')
                    ->options([
                        'blue' => 'Синий фон, белый текст',
                        'light' => 'Светлый фон',
                        'dark' => 'Тёмный фон, белый текст',
                        'none' => 'Без фона',
                    ])
                    ->default('blue'),
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
                Forms\Components\Repeater::make('data_languages.headers')
                    ->label('Заголовки столбцов')
                    ->schema([
                        Forms\Components\TextInput::make('text')
                            ->label('Название столбца')
                            ->required(),
                    ])
                    ->defaultItems(3)
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('data_languages.rows')
                    ->label('Строки')
                    ->schema([
                        Forms\Components\Toggle::make('is_accent')
                            ->label('Акцентная строка (на всю ширину)')
                            ->default(false),
                        Forms\Components\TextInput::make('accent_text')
                            ->label('Текст акцентной строки')
                            ->visible(fn ($get) => $get('is_accent')),
                        Forms\Components\Repeater::make('cells')
                            ->label('Ячейки')
                            ->schema([
                                Forms\Components\TextInput::make('text')
                                    ->label('Значение')
                                    ->required(),
                            ])
                            ->defaultItems(3)
                            ->visible(fn ($get) => !$get('is_accent')),
                    ])
                    ->defaultItems(3)
                    ->columnSpanFull(),
                ...$this->spacingSelectFields(),
            ],

            'key_figure' => [
                Forms\Components\TextInput::make('data_languages.value')
                    ->label('Значение (число)')
                    ->placeholder('725 млрд руб.')
                    ->required(),
                Forms\Components\TextInput::make('data_languages.description')
                    ->label('Описание')
                    ->placeholder('инвестиции в модернизацию')
                    ->required(),
                Forms\Components\RichEditor::make('data_languages.context')
                    ->plugins([
                        TooltipRichContentPlugin::make(),
                    ])
                    ->enableToolbarButtons([
                        'tooltip',
                        'removeTooltip',
                    ])
                    ->label('Контекст (необязательный текст рядом)')
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
                Forms\Components\Select::make('data_languages.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
                Forms\Components\Select::make('data_languages.text_color')
                    ->label('Цвет текста')
                    ->options([
                        'auto' => 'Авто (белый для тёмного фона)',
                        'white' => 'Белый',
                        'dark' => 'Тёмный',
                    ])
                    ->default('auto'),
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
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
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
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
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
                Forms\Components\Select::make('data_languages.spacing')
                    ->label('Отступ снизу')
                    ->options([
                        'none' => 'Без отступа',
                        'small' => 'Маленький (8px)',
                        'normal' => 'Обычный (16px)',
                        'large' => 'Большой (32px)',
                        'xl' => 'Очень большой (48px)',
                    ])
                    ->default('normal'),
            ],

            'info_block' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\RichEditor::make('data_languages.ru.content')
                                    ->label('Текст')
                                    ->plugins([
                                        TooltipRichContentPlugin::make(),
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
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
                                    ])
                                    ->enableToolbarButtons([
                                        'tooltip',
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
                Forms\Components\Select::make('data_languages.text_color')
                    ->label('Цвет текста')
                    ->options([
                        'auto' => 'Авто (по стилю)',
                        'white' => 'Белый',
                        'dark' => 'Тёмный',
                    ])
                    ->default('auto'),
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
            ],

            'timeline' => [
                Forms\Components\TextInput::make('data_languages.title')
                    ->label('Заголовок таймлайна'),
                Forms\Components\Repeater::make('data_languages.events')
                    ->label('События')
                    ->schema([
                        Forms\Components\TextInput::make('year')
                            ->label('Год / дата')
                            ->required(),
                        Forms\Components\Textarea::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->rows(2),
                        Forms\Components\Textarea::make('description')
                            ->label('Описание'),
                    ])
                    ->defaultItems(3)
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
                ...$this->spacingSelectFields(),
            ],

            'numbered_steps' => [
                Tabs::make('language_tabs')
                    ->tabs([
                        Tab::make('Русский')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.ru.title')
                                    ->label('Заголовок'),
                                Forms\Components\Repeater::make('data_languages.ru.steps')
                                    ->label('Шаги')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок шага'),
                                        Forms\Components\Select::make('title_style')
                                            ->label('Стиль заголовка')
                                            ->options([
                                                'large_bold' => 'Крупный жирный',
                                                'normal' => 'Обычный',
                                                'small' => 'Мелкий',
                                                'accent' => 'Акцентный цветной',
                                                'muted' => 'Серый приглушённый',
                                            ])
                                            ->default('large_bold'),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Описание'),
                                        Forms\Components\Select::make('desc_style')
                                            ->label('Стиль описания')
                                            ->options([
                                                'large_bold' => 'Крупный жирный',
                                                'normal' => 'Обычный',
                                                'small' => 'Мелкий',
                                                'accent' => 'Акцентный цветной',
                                                'muted' => 'Серый приглушённый',
                                            ])
                                            ->default('normal'),
                                    ])
                                    ->defaultItems(3)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('data_languages.en.title')
                                    ->label('Title'),
                                Forms\Components\Repeater::make('data_languages.en.steps')
                                    ->label('Steps')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Step title'),
                                        Forms\Components\Select::make('title_style')
                                            ->label('Title style')
                                            ->options([
                                                'large_bold' => 'Large bold',
                                                'normal' => 'Normal',
                                                'small' => 'Small',
                                                'accent' => 'Accent colored',
                                                'muted' => 'Muted gray',
                                            ])
                                            ->default('large_bold'),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Description'),
                                        Forms\Components\Select::make('desc_style')
                                            ->label('Description style')
                                            ->options([
                                                'large_bold' => 'Large bold',
                                                'normal' => 'Normal',
                                                'small' => 'Small',
                                                'accent' => 'Accent colored',
                                                'muted' => 'Muted gray',
                                            ])
                                            ->default('normal'),
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
                Forms\Components\Select::make('data_languages.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('accent'),
                Forms\Components\Select::make('data_languages.spacing')
                    ->label('Отступ снизу')
                    ->options([
                        'none' => 'Без отступа',
                        'small' => 'Маленький (8px)',
                        'normal' => 'Обычный (16px)',
                        'large' => 'Большой (32px)',
                        'xl' => 'Очень большой (48px)',
                    ])
                    ->default('normal'),
            ],

            'cards_grid' => [
                Forms\Components\Repeater::make('data_languages.cards')
                    ->label('Карточки')
                    ->schema([
                        Forms\Components\FileUpload::make('icon')
                            ->label('Иконка / изображение')
                            ->image()
                            ->directory('report-images'),
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required(),
                        Forms\Components\Textarea::make('text')
                            ->label('Текст'),
                    ])
                    ->defaultItems(3)
                    ->columnSpanFull(),
                Forms\Components\Select::make('data_languages.columns')
                    ->label('Колонок в ряду')
                    ->options([
                        '2' => '2 колонки',
                        '3' => '3 колонки',
                        '4' => '4 колонки',
                    ])
                    ->default('3'),
                Forms\Components\Select::make('data_languages.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
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
                Forms\Components\Select::make('data_languages.spacing')
                    ->label('Отступ снизу')
                    ->options([
                        'none' => 'Без отступа',
                        'small' => 'Маленький (8px)',
                        'normal' => 'Обычный (16px)',
                        'large' => 'Большой (32px)',
                        'xl' => 'Очень большой (48px)',
                    ])
                    ->default('normal'),
            ],

            'icon_list' => [
                Forms\Components\Repeater::make('data_languages.items')
                    ->label('Пункты')
                    ->schema([
                        Forms\Components\FileUpload::make('icon')
                            ->label('Иконка (PNG/SVG)')
                            ->image()
                            ->directory('report-images'),
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required(),
                        Forms\Components\Textarea::make('text')
                            ->label('Описание'),
                        Forms\Components\Select::make('title_style')
                            ->label('Стиль заголовка')
                            ->options([
                                'large_bold' => 'Крупный жирный',
                                'normal' => 'Обычный',
                                'small' => 'Мелкий',
                                'accent' => 'Акцентный цветной',
                                'muted' => 'Серый приглушённый',
                            ])
                            ->default('large_bold'),
                    ])
                    ->defaultItems(3)
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
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
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
                TextColumn::make('type')
                    ->label('Тип')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'text-with-title' => 'Текст с заголовком',
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
                            'icon_list' => ($data_languages['items'][0]['title'] ?? ''),
                            'table' => ($data_languages['headers'][0]['text'] ?? ''),
                            'image' => '',
                            'image_row' => '',
                            'two_columns' => strip_tags($data_languages['left'] ?? ''),
                            default => '',
                        };

                        // Для изображений добавляем HTML превью
                        if ($record->type === 'image' && !empty($data_languages['url'])) {
                            $url = str_starts_with($data_languages['url'], 'http') ? $data_languages['url'] : asset('storage/' . $data_languages['url']);
                            $content = '<img src="' . $url . '" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">';
                        }
                        if ($record->type === 'image_row' && !empty($data_languages['images'][0]['url'])) {
                            $url = str_starts_with($data_languages['images'][0]['url'], 'http') ? $data_languages['images'][0]['url'] : asset('storage/' . $data_languages['images'][0]['url']);
                            $content = '<img src="' . $url . '" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">';
                        }

                        return $content;
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
                        return '';
                    })
                    ->visible(fn ($record): bool => $record ? in_array($record->type, ['stats_grid', 'timeline', 'numbered_steps', 'cards_grid', 'image_row', 'table', 'icon_list']) : false),
                TextColumn::make('sort')
                    ->label('Сортировка')
                    ->sortable(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->filters([
                //
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
}
