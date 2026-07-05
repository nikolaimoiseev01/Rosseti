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
                                Block::make('text')
                                    ->schema([
                                        TextInput::make('title'),
                                        Forms\Components\RichEditor::make('text')
                                            ->label('Текст')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                                Block::make('image')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->label('Изображение')
                                            ->image()
                                            ->disk('public')
                                            ->directory('page-blocks')
                                            ->maxSize(10240)
                                            ->visible(fn ($get) => $get('type') === 'image')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
