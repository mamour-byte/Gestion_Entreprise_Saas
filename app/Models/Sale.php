<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CompanyScope;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'company_id',
        'employee_id',
        'product_id',
        'quantity',
        'sale_date',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'total_amount',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
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
            static::creating(function ($sale) {
                if (auth()->check()) {
                    $sale->compagny_id = auth()->user()->compagny_id;
                }
            });
        }
}
