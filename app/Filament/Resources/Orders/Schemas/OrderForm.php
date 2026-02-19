<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                select::make('user_id')
                    ->required()
                    ->relationship('user', 'name'),
                TextInput::make('Total_amt')
                    ->required(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancel' => 'Cancel',
                    ])
                    ->default('pending')
                    ->required(),
                Select::make('veri_status')
                    ->options(['verified' => 'Verified', 'unverified' => 'Unverified'])
                    ->default('unverified')
                    ->required(),
                FileUpload::make('payement_receipt')
                  
                    ->required(),
            ]);
    }
}
