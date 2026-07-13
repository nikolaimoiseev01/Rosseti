<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

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
use Filament\Schemas\Schema;
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
                    ])
                    ->live()
                    ->afterStateUpdated(function (
                        Select $component,
                        Set $set,
                        ?string $state,
                    ): void {
                        /*
                         * Важно создать вложенные ключи до того,
                         * как RichEditor выполнит entangle.
                         */
                        $set('data', match ($state) {
                            'rich_text' => [
                                'content' => '',
                                'text_color' => 'default',
                                'spacing' => 'normal',
                            ],

                            default => [],
                        });

                        /*
                         * Инициализируем динамически появившиеся компоненты.
                         */
                        $component
                            ->getContainer()
                            ->getComponent('blockSettings')
                            ->getChildSchema()
                            ->fill();
                    })
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),

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
                TextInput::make('data.title')
                    ->label('Заголовок')
                    ->required(),
                Forms\Components\RichEditor::make('data.text')
                    ->label('Текст')
                    ->required()
                    ->columnSpanFull(),
            ],

            'rich_text' => [
                Forms\Components\RichEditor::make('data.content')
                    ->label('Содержимое')
                    ->required()
                    ->columnSpanFull()
                    ->default('')
                    ->fileAttachmentsVisibility('public'),
                Forms\Components\Select::make('data.text_color')
                    ->label('Цвет текста')
                    ->options([
                        'default' => 'Чёрный (по умолчанию)',
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                        'muted' => 'Серый',
                        'white' => 'Белый (для тёмных фонов)',
                    ])
                    ->default('default'),
                Forms\Components\Select::make('data.spacing')
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

            'image' => [
                Forms\Components\FileUpload::make('data.url')
                    ->label('Изображение')
                    ->image()
                    ->directory('report-images')
                    ->required(),
                Forms\Components\TextInput::make('data.caption')
                    ->label('Подпись к изображению'),
                Forms\Components\Select::make('data.size')
                    ->label('Размер')
                    ->options([
                        'full' => 'На всю ширину',
                        'large' => 'Большое (75%)',
                        'medium' => 'Среднее (50%)',
                    ])
                    ->default('full'),
            ],

            'two_columns' => [
                Forms\Components\RichEditor::make('data.left')
                    ->label('Левая колонка')
                    ->required(),
                Forms\Components\RichEditor::make('data.right')
                    ->label('Правая колонка')
                    ->required(),
            ],

            'stats_grid' => [
                Forms\Components\Repeater::make('data.items')
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
            ],

            'quote' => [
                Forms\Components\Textarea::make('data.text')
                    ->label('Текст цитаты')
                    ->rows(3)
                    ->required(),
                Forms\Components\TextInput::make('data.author')
                    ->label('Автор'),
                Forms\Components\TextInput::make('data.position')
                    ->label('Должность'),
            ],

            'heading' => [
                Forms\Components\TextInput::make('data.content')
                    ->label('Текст заголовка')
                    ->required(),
                Forms\Components\Select::make('data.level')
                    ->label('Уровень')
                    ->options([
                        'h2' => 'H2 — Крупный',
                        'h3' => 'H3 — Средний',
                        'h4' => 'H4 — Маленький',
                    ])
                    ->default('h2'),
                Forms\Components\Select::make('data.color')
                    ->label('Цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                        'dark' => 'Чёрный',
                        'white' => 'Белый (для тёмных фонов)',
                    ])
                    ->default('primary'),
            ],

            'gri_reference' => [
                Forms\Components\TextInput::make('data.codes')
                    ->label('Коды GRI')
                    ->helperText('Например: GRI 2-1, 2-6')
                    ->required(),
            ],

            'image_row' => [
                Forms\Components\Repeater::make('data.images')
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
                Forms\Components\Select::make('data.size')
                    ->label('Размер каждого элемента')
                    ->options([
                        'small' => 'Маленький (иконки, ~60px)',
                        'medium' => 'Средний (~120px)',
                        'large' => 'Большой (~200px)',
                        'xlarge' => 'Крупный (~300px)',
                        'xxlarge' => 'Очень крупный (~400px)',
                        'full' => 'На всю ширину (~500px)',
                    ])
                    ->default('small'),
                Forms\Components\Select::make('data.gap')
                    ->label('Расстояние между')
                    ->options([
                        'tight' => 'Плотно (4px)',
                        'normal' => 'Обычно (12px)',
                        'wide' => 'Широко (24px)',
                    ])
                    ->default('normal'),
            ],

            'table' => [
                Forms\Components\TextInput::make('data.caption')
                    ->label('Заголовок таблицы'),
                Forms\Components\Select::make('data.header_style')
                    ->label('Стиль заголовков')
                    ->options([
                        'blue' => 'Синий фон, белый текст',
                        'light' => 'Светлый фон',
                        'none' => 'Без фона',
                    ])
                    ->default('blue'),
                Forms\Components\Select::make('data.cell_padding')
                    ->label('Отступы в ячейках')
                    ->options([
                        'compact' => 'Компактные',
                        'normal' => 'Обычные',
                        'spacious' => 'Просторные',
                    ])
                    ->default('normal'),
                Forms\Components\Repeater::make('data.headers')
                    ->label('Заголовки столбцов')
                    ->schema([
                        Forms\Components\TextInput::make('text')
                            ->label('Название столбца')
                            ->required(),
                    ])
                    ->defaultItems(3)
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('data.rows')
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
            ],

            'key_figure' => [
                Forms\Components\TextInput::make('data.value')
                    ->label('Значение (число)')
                    ->placeholder('725 млрд руб.')
                    ->required(),
                Forms\Components\TextInput::make('data.description')
                    ->label('Описание')
                    ->placeholder('инвестиции в модернизацию')
                    ->required(),
                Forms\Components\RichEditor::make('data.context')
                    ->label('Контекст (необязательный текст рядом)')
                    ->columnSpanFull(),
                Forms\Components\Select::make('data.style')
                    ->label('Стиль оформления')
                    ->options([
                        'card_blue' => 'Карточка (синий фон)',
                        'card_light' => 'Карточка (светлый фон)',
                        'inline_large' => 'Крупная цифра по центру',
                        'inline_left' => 'Цифра слева, текст справа',
                        'accent_border' => 'С акцентной полоской слева',
                    ])
                    ->default('card_blue'),
                Forms\Components\Select::make('data.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
            ],

            'subtitle' => [
                Forms\Components\TextInput::make('data.text')
                    ->label('Текст подзаголовка')
                    ->required(),
                Forms\Components\Select::make('data.style')
                    ->label('Стиль')
                    ->options([
                        'default' => 'Обычный (чёрный)',
                        'accent' => 'Акцентный (цветной)',
                        'uppercase' => 'Капслок (маленький, трекинг)',
                    ])
                    ->default('default'),
                Forms\Components\Select::make('data.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
            ],

            'person_card' => [
                Forms\Components\TextInput::make('data.heading')
                    ->label('Заголовок (вопрос)')
                    ->placeholder('Как экологическая ответственность проявляется...'),
                Forms\Components\RichEditor::make('data.text')
                    ->label('Текст / цитата')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('data.photo')
                    ->label('Фото')
                    ->image()
                    ->directory('report-images')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1'),
                Forms\Components\TextInput::make('data.name')
                    ->label('Имя')
                    ->required(),
                Forms\Components\TextInput::make('data.position')
                    ->label('Должность'),
                Forms\Components\Select::make('data.color')
                    ->label('Цвет заголовка')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
            ],

            'info_block' => [
                Forms\Components\RichEditor::make('data.content')
                    ->label('Текст')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('data.style')
                    ->label('Стиль')
                    ->options([
                        'blue' => 'Синий фон (белый текст)',
                        'light' => 'Светлый фон',
                        'accent' => 'Голубая полоска слева',
                        'dark' => 'Тёмный фон (белый текст)',
                    ])
                    ->default('light'),
                Forms\Components\Select::make('data.text_size')
                    ->label('Размер текста')
                    ->options([
                        'small' => 'Мелкий',
                        'normal' => 'Обычный',
                        'large' => 'Крупный',
                    ])
                    ->default('normal'),
            ],

            'divider' => [
                Forms\Components\Select::make('data.style')
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
                Forms\Components\TextInput::make('data.title')
                    ->label('Заголовок таймлайна'),
                Forms\Components\Repeater::make('data.events')
                    ->label('События')
                    ->schema([
                        Forms\Components\TextInput::make('year')
                            ->label('Год / дата')
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('Описание'),
                    ])
                    ->defaultItems(3)
                    ->columnSpanFull(),
                Forms\Components\Select::make('data.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
            ],

            'numbered_steps' => [
                Forms\Components\TextInput::make('data.title')
                    ->label('Заголовок'),
                Forms\Components\Select::make('data.icon_style')
                    ->label('Стиль иконки')
                    ->options([
                        'numbers' => 'Цифры (01, 02...)',
                        'checkmarks' => 'Галочки ✓',
                        'dots' => 'Точки ●',
                    ])
                    ->default('numbers'),
                Forms\Components\Toggle::make('data.connected')
                    ->label('Соединять линией')
                    ->default(false),
                Forms\Components\Repeater::make('data.steps')
                    ->label('Шаги')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок шага')
                            ->required(),
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
                Forms\Components\Select::make('data.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('accent'),
            ],

            'cards_grid' => [
                Forms\Components\Repeater::make('data.cards')
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
                Forms\Components\Select::make('data.columns')
                    ->label('Колонок в ряду')
                    ->options([
                        '2' => '2 колонки',
                        '3' => '3 колонки',
                        '4' => '4 колонки',
                    ])
                    ->default('3'),
                Forms\Components\Select::make('data.color')
                    ->label('Акцентный цвет')
                    ->options([
                        'primary' => 'Тёмно-синий (#00355A)',
                        'accent' => 'Голубой (#2196F3)',
                    ])
                    ->default('primary'),
            ],

            'icon_list' => [
                Forms\Components\Repeater::make('data.items')
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
                Forms\Components\Select::make('data.icon_size')
                    ->label('Размер иконок')
                    ->options([
                        'small' => 'Маленький (24px)',
                        'medium' => 'Средний (40px)',
                        'large' => 'Большой (60px)',
                    ])
                    ->default('medium'),
                Forms\Components\Select::make('data.color')
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
}
