<?php

namespace App\Filament\Resources\PageResource\Schemas;

use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                        Forms\Components\TextInput::make('title_languages.ru')
                            ->label('Название (RU)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('title_languages.en')
                            ->label('Название (EN)')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_page_languages.ru')
                            ->label('Заголовок на странице (RU)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_page_languages.en')
                            ->label('Заголовок на странице (EN)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('description')
                            ->label('Описание')
                            ->required()
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
                        SpatieMediaLibraryFileUpload::make('cover_mobile')
                            ->label('Обложка мобильная версия')
                            ->collection('cover_mobile')
                            ->image()
                            ->maxFiles(1)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('cover_height')
                            ->label('Высота обложки')
                            ->options([
                                '216px' => 'Стандартная (216px)',
                                '400px' => 'Маленькая (400px)',
                                '500px' => 'Средняя (500px)',
                                '642px' => 'Большая (642px)',
                                '800px' => 'Очень большая (800px)',
                                'full' => 'На всю высоту',
                                'custom' => 'Кастомная',
                            ])
                            ->default('642px')
                            ->helperText('Выберите высоту обложки на странице'),
                    ]),
            ]);
    }
}
