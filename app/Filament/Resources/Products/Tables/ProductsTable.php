<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('price')
                    ->prefix('Rs. ')
                    ->sortable(),

                TextColumn::make('discount')
                    ->suffix(' %')
                    ->numeric()
                    ->sortable(),

                ImageColumn::make('image')
                    ->square()
                    ->size(50),

                ImageColumn::make('featured_image')
                    ->label('Featured Banner')
                    ->square()
                    ->size(80)
                    ->defaultImageUrl(fn ($record) => $record?->image
                        ? asset('storage/' . $record->image)
                        : null
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('category.title')
                    ->searchable(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('featured_order')
                    ->label('Order')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_featured')
                    ->label('Featured Products')
                    ->placeholder('All products')
                    ->trueLabel('Featured only')
                    ->falseLabel('Non-featured only'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('featured_order', 'asc');
    }
}
