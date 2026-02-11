<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Products")
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        RichEditor::make('description')
                            ->required(),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('Rs'),
                        TextInput::make('discount')
                            ->suffix('%')
                            ->required()
                            ->numeric(),
                        FileUpload::make('image')
                            ->image()
                            ->required(),
                        Select::make('category_id')
                            ->relationship('category', 'title')
                            ->required()
                            ->createOptionForm([
                                TextInput::make('title')
                                    ->required(),
                            ]),
                    ])
            ]);
    }
}
