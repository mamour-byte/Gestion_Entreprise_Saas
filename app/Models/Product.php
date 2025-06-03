<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CompanyScope;
use App\Models\Sale;
use App\Models\Company;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'company_id',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    protected static function booted(): void
        {
            parent::booted();

            // pour filtrer les ventes par company_id
            static::addGlobalScope(new CompanyScope);

            // Attribution automatique de company_id à la création
            static::creating(function ($product) {
                if (auth()->check()) {
                    $product->company_id = auth()->user()->company_id;
                }
            });
        }
}
