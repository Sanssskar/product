<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
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
                TextInput::make('payement_receipt')
                    ->required(),
            ]);
    }
}
