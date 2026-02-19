<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Http\Resources\Order_ItemResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('Total_amt')
                    ->searchable(),
                SelectColumn::make('status')
                    ->options([
                        "pending" => 'Pending',
                        "approved" => 'Approved',
                        "shipped" => 'Shipped',
                        "delivered" => 'Delivered',
                        "cancel" => 'Cancel'
                    ]),
                SelectColumn::make('veri_status')
                    ->options([
                        "verified" => "Verified",
                        "unverified" => "Unverified"
                    ]),
                ImageColumn::make('payment_receipt')
                   ->square(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            // ->recordActions([
            //     // EditAction::make(),
            //     Action::make("General")
            //         ->url(fn($item) => route('order.details', $item), true)
            // ])
            ->recordActions([
                ViewAction::make()
                    ->label('View Order')
                    ->url(fn(Order $record) => route('order.details', $record))
                    ->openUrlInNewTab()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
