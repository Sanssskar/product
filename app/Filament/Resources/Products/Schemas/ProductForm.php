<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required(),

                        Select::make('category_id')
                            ->relationship('category', 'title')
                            ->required()
                            ->createOptionForm([
                                TextInput::make('title')
                                    ->required(),
                            ]),

                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('Rs'),

                        TextInput::make('discount')
                            ->suffix('%')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),

                        RichEditor::make('description')
                            ->columnSpanFull()
                            ->extraInputAttributes([
                                'style' => 'min-height: 200px;'
                            ])
                            ->required(),

                        FileUpload::make('image')
                            ->image()
                            ->required(),
                    ]),

                Section::make('Featured Showcase')
                    ->description('Mark this product to appear in the featured banner section.')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Mark as Featured')
                            ->helperText('Featured products appear in the homepage showcase.')
                            ->live()
                            ->columnSpanFull(),

                        TextInput::make('featured_order')
                            ->label('Display Order')
                            ->helperText('Lower number = shown first. Leave 0 for default.')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->visible(fn ($get) => $get('is_featured')),

                        FileUpload::make('featured_image')
                            ->label('Featured Banner Image')
                            ->helperText('Recommended: 1200×400px. Falls back to product image if left empty.')
                            ->image()
                            ->nullable()
                            ->visible(fn ($get) => $get('is_featured')),
                    ]),
            ]);
    }
}
