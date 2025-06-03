<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{

    public static function getMiddleware(): array
        {
            return [
                'auth',
                'verified',
                'belongs.to.company',
            ];
        }
        
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('customer_name')
                    ->label('Customer Name')
                    ->required(),
                Forms\Components\TextInput::make('customer_email')
                    ->label('Customer Email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('customer_phone')
                    ->label('Customer Phone'),
                Forms\Components\TextInput::make('customer_address')
                    ->label('Customer Address')
                ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Customer Phone'),
                Tables\Columns\TextColumn::make('customer_address')
                    ->label('Customer Address'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Sale Date')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
