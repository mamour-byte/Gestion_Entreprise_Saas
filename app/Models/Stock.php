<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CompanyScope;
use App\Models\Product;
use App\Models\Company;

class Stock extends Model
    {
        
    protected $fillable = [
        'company_id',
        'product_id',
        'type',
        'quantity',
    ];
    protected $casts = [
        'type' => 'string',
        'quantity' => 'integer',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected static function booted(): void
        {
            parent::booted();

            // pour filtrer les ventes par company_id
            static::addGlobalScope(new CompanyScope);

            // Attribution automatique de company_id à la création
            static::creating(function ($stock) {
                if (auth()->check()) {
                    $stock->company_id = auth()->user()->company_id;
                }
            });
        }

}
