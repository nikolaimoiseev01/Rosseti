<?php

namespace App\Filament\Resources\PageResource\Schemas;

use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основное')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Активна')
                            ->default(true),

                        Forms\Components\TextInput::make('sort')
                            ->label('Сортировка')
                            ->numeric()
                            ->default(0),
                    ]),

                Section::make('Обложка')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->label('Обложка')
                            ->collection('cover')
                            ->image()
                            ->maxFiles(1)
                            ->columnSpanFull(),
                    ]),

                Section::make('Контент')
                    ->columnSpanFull()
                    ->schema([
                        Builder::make('content')
                            ->blocks([
                                Block::make('text-with-title')
                                    ->schema([
                                        TextInput::make('title'),
                                        Forms\Components\RichEditor::make('text')
                                            ->label('Текст')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                                Block::make('image')
                                    ->label('Изображение')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        Forms\Components\FileUpload::make('url')
                                            ->label('Изображение')
                                            ->image()
                                            ->directory('report-images')
                                            ->required(),
                                        Forms\Components\TextInput::make('caption')
                                            ->label('Подпись к изображению'),
                                        Forms\Components\Select::make('size')
                                            ->label('Размер')
                                            ->options([
                                                'full' => 'На всю ширину',
                                                'large' => 'Большое (75%)',
                                                'medium' => 'Среднее (50%)',
                                            ])
                                            ->default('full'),
                                    ]),

                                // 3. Two Column Text
                                Block::make('two_columns')
                                    ->label('Текст в две колонки')
                                    ->icon('heroicon-o-view-columns')
                                    ->schema([
                                        Forms\Components\RichEditor::make('left')
                                            ->label('Левая колонка')
                                            ->required(),
                                        Forms\Components\RichEditor::make('right')
                                            ->label('Правая колонка')
                                            ->required(),
                                    ]),

                                // 4. Stats Grid
                                Block::make('stats_grid')
                                    ->label('Сетка показателей')
                                    ->icon('heroicon-o-chart-bar')
                                    ->schema([
                                        Forms\Components\Repeater::make('items')
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

                                // 5. Quote
                                Block::make('quote')
                                    ->label('Цитата')
                                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                                    ->schema([
                                        Forms\Components\Textarea::make('text')
                                            ->label('Текст цитаты')
                                            ->rows(3)
                                            ->required(),
                                        Forms\Components\TextInput::make('author')
                                            ->label('Автор'),
                                        Forms\Components\TextInput::make('position')
                                            ->label('Должность'),
                                    ]),

                                // 6. Heading
                                Block::make('heading')
                                    ->label('Заголовок')
                                    ->icon('heroicon-o-hashtag')
                                    ->schema([
                                        Forms\Components\TextInput::make('content')
                                            ->label('Текст заголовка')
                                            ->required(),
                                        Forms\Components\Select::make('level')
                                            ->label('Уровень')
                                            ->options([
                                                'h2' => 'H2 — Крупный',
                                                'h3' => 'H3 — Средний',
                                                'h4' => 'H4 — Маленький',
                                            ])
                                            ->default('h2'),
                                        Forms\Components\Select::make('color')
                                            ->label('Цвет')
                                            ->options([
                                                'primary' => 'Тёмно-синий (#00355A)',
                                                'accent' => 'Голубой (#2196F3)',
                                                'dark' => 'Чёрный',
                                                'white' => 'Белый (для тёмных фонов)',
                                            ])
                                            ->default('primary'),
                                    ]),

                                // 7. GRI Reference
                                Block::make('gri_reference')
                                    ->label('GRI ссылка')
                                    ->icon('heroicon-o-bookmark')
                                    ->schema([
                                        Forms\Components\TextInput::make('codes')
                                            ->label('Коды GRI')
                                            ->helperText('Например: GRI 2-1, 2-6')
                                            ->required(),
                                    ]),

                                // 8. Image Row (multiple images/icons in a row)
                                Block::make('image_row')
                                    ->label('Изображения в ряд')
                                    ->icon('heroicon-o-squares-2x2')
                                    ->schema([
                                        Forms\Components\Repeater::make('images')
                                            ->label('Изображения')
                                            ->schema([
                                                Forms\Components\FileUpload::make('url')
                                                    ->label('Изображение')
                                                    ->image()
                                                    ->directory('report-images')
                                                    ->required(),
                                                Forms\Components\TextInput::make('alt')
                                                    ->label('Подпись (alt)'),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(3)
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('size')
                                            ->label('Размер каждого элемента')
                                            ->options([
                                                'small' => 'Маленький (иконки, ~60px)',
                                                'medium' => 'Средний (~120px)',
                                                'large' => 'Большой (~200px)',
                                            ])
                                            ->default('small'),
                                        Forms\Components\Select::make('gap')
                                            ->label('Расстояние между')
                                            ->options([
                                                'tight' => 'Плотно (4px)',
                                                'normal' => 'Обычно (12px)',
                                                'wide' => 'Широко (24px)',
                                            ])
                                            ->default('normal'),
                                    ]),

                                // 9. Table
                                Block::make('table')
                                    ->label('Таблица')
                                    ->icon('heroicon-o-table-cells')
                                    ->schema([
                                        Forms\Components\TextInput::make('caption')
                                            ->label('Заголовок таблицы'),
                                        Forms\Components\Repeater::make('headers')
                                            ->label('Заголовки столбцов')
                                            ->schema([
                                                Forms\Components\TextInput::make('text')
                                                    ->label('Название столбца')
                                                    ->required(),
                                            ])
                                            ->defaultItems(3)
                                            ->columnSpanFull(),
                                        Forms\Components\Repeater::make('rows')
                                            ->label('Строки')
                                            ->schema([
                                                Forms\Components\Repeater::make('cells')
                                                    ->label('Ячейки')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('text')
                                                            ->label('Значение')
                                                            ->required(),
                                                    ])
                                                    ->defaultItems(3),
                                            ])
                                            ->defaultItems(3)
                                            ->columnSpanFull(),
                                    ]),

                                // 10. Key Figure (highlighted number)
                                Block::make('key_figure')
                                    ->label('Ключевая цифра')
                                    ->icon('heroicon-o-presentation-chart-bar')
                                    ->schema([
                                        Forms\Components\TextInput::make('value')
                                            ->label('Значение (число)')
                                            ->placeholder('725 млрд руб.')
                                            ->required(),
                                        Forms\Components\TextInput::make('description')
                                            ->label('Описание')
                                            ->placeholder('инвестиции в модернизацию')
                                            ->required(),
                                        Forms\Components\RichEditor::make('context')
                                            ->label('Контекст (необязательный текст рядом)')
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('style')
                                            ->label('Стиль оформления')
                                            ->options([
                                                'card_blue' => 'Карточка (синий фон)',
                                                'card_light' => 'Карточка (светлый фон)',
                                                'inline_large' => 'Крупная цифра по центру',
                                                'inline_left' => 'Цифра слева, текст справа',
                                                'accent_border' => 'С акцентной полоской слева',
                                            ])
                                            ->default('card_blue'),
                                        Forms\Components\Select::make('color')
                                            ->label('Акцентный цвет')
                                            ->options([
                                                'primary' => 'Тёмно-синий (#00355A)',
                                                'accent' => 'Голубой (#2196F3)',
                                            ])
                                            ->default('primary'),
                                    ]),

                                // 11. Subtitle (decorative subheading)
                                Block::make('subtitle')
                                    ->label('Подзаголовок')
                                    ->icon('heroicon-o-bars-3-bottom-left')
                                    ->schema([
                                        Forms\Components\TextInput::make('text')
                                            ->label('Текст подзаголовка')
                                            ->required(),
                                        Forms\Components\Select::make('style')
                                            ->label('Стиль')
                                            ->options([
                                                'default' => 'Обычный (серый, мелкий)',
                                                'accent' => 'Акцентный (с линией)',
                                                'uppercase' => 'Капслок (маленький, трекинг)',
                                            ])
                                            ->default('default'),
                                        Forms\Components\Select::make('color')
                                            ->label('Акцентный цвет')
                                            ->options([
                                                'primary' => 'Тёмно-синий (#00355A)',
                                                'accent' => 'Голубой (#2196F3)',
                                            ])
                                            ->default('primary'),
                                    ]),

                                // 12. Person Card (quote + circular photo)
                                Block::make('person_card')
                                    ->label('Карточка сотрудника')
                                    ->icon('heroicon-o-user-circle')
                                    ->schema([
                                        Forms\Components\TextInput::make('heading')
                                            ->label('Заголовок (вопрос)')
                                            ->placeholder('Как экологическая ответственность проявляется...'),
                                        Forms\Components\RichEditor::make('text')
                                            ->label('Текст / цитата')
                                            ->required()
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('photo')
                                            ->label('Фото')
                                            ->image()
                                            ->directory('report-images')
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('1:1'),
                                        Forms\Components\TextInput::make('name')
                                            ->label('Имя')
                                            ->required(),
                                        Forms\Components\TextInput::make('position')
                                            ->label('Должность'),
                                        Forms\Components\Select::make('color')
                                            ->label('Цвет заголовка')
                                            ->options([
                                                'primary' => 'Тёмно-синий (#00355A)',
                                                'accent' => 'Голубой (#2196F3)',
                                            ])
                                            ->default('primary'),
                                    ]),

                                // 13. Info Block (colored background)
                                Block::make('info_block')
                                    ->label('Информационный блок')
                                    ->icon('heroicon-o-information-circle')
                                    ->schema([
                                        Forms\Components\RichEditor::make('content')
                                            ->label('Текст')
                                            ->required()
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('style')
                                            ->label('Стиль')
                                            ->options([
                                                'blue' => 'Синий фон',
                                                'light' => 'Светлый фон',
                                                'accent' => 'Голубая полоска слева',
                                                'dark' => 'Тёмный фон',
                                            ])
                                            ->default('light'),
                                    ]),

                                // 14. Divider
                                Block::make('divider')
                                    ->label('Разделитель')
                                    ->icon('heroicon-o-minus')
                                    ->schema([
                                        Forms\Components\Select::make('style')
                                            ->label('Стиль')
                                            ->options([
                                                'line' => 'Тонкая линия',
                                                'thick' => 'Толстая линия',
                                                'space' => 'Только отступ',
                                                'dots' => 'Точки',
                                            ])
                                            ->default('line'),
                                    ]),

                                // 15. Timeline
                                Block::make('timeline')
                                    ->label('Таймлайн')
                                    ->icon('heroicon-o-clock')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок таймлайна'),
                                        Forms\Components\Repeater::make('events')
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
                                        Forms\Components\Select::make('color')
                                            ->label('Акцентный цвет')
                                            ->options([
                                                'primary' => 'Тёмно-синий (#00355A)',
                                                'accent' => 'Голубой (#2196F3)',
                                            ])
                                            ->default('primary'),
                                    ]),

                                // 16. Numbered Steps
                                Block::make('numbered_steps')
                                    ->label('Нумерованные шаги')
                                    ->icon('heroicon-o-list-bullet')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Заголовок'),
                                        Forms\Components\Repeater::make('steps')
                                            ->label('Шаги')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Заголовок шага')
                                                    ->required(),
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Описание'),
                                            ])
                                            ->defaultItems(3)
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('color')
                                            ->label('Акцентный цвет')
                                            ->options([
                                                'primary' => 'Тёмно-синий (#00355A)',
                                                'accent' => 'Голубой (#2196F3)',
                                            ])
                                            ->default('primary'),
                                    ]),

                                // 17. Cards Grid
                                Block::make('cards_grid')
                                    ->label('Сетка карточек')
                                    ->icon('heroicon-o-rectangle-group')
                                    ->schema([
                                        Forms\Components\Repeater::make('cards')
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
                                        Forms\Components\Select::make('columns')
                                            ->label('Колонок в ряду')
                                            ->options([
                                                '2' => '2 колонки',
                                                '3' => '3 колонки',
                                                '4' => '4 колонки',
                                            ])
                                            ->default('3'),
                                        Forms\Components\Select::make('color')
                                            ->label('Акцентный цвет')
                                            ->options([
                                                'primary' => 'Тёмно-синий (#00355A)',
                                                'accent' => 'Голубой (#2196F3)',
                                            ])
                                            ->default('primary'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
