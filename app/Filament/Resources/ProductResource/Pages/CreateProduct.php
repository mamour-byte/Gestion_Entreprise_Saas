<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock; // Assurez-vous d'importer le modèle Stock
use App\Models\Product; // Assurez-vous d'importer le modèle Product

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Enregistre d'abord le produit
        $product = static::getModel()::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            // 'quantity' => $data['quantity'],
        ]);

        // Ensuite, crée l'entrée dans le stock
        Stock::create([
            'product_id' => $product->id,
            'type' => 'in', 
            'quantity' => $data['quantity'],
        ]);

        return $product;
    }
}
