<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CompanyScope;
use App\Models\Sale;
use App\Models\Company;

class Employee extends Model
{
    
    protected $fillable = [
        'name',
        'email',
        'position',
        'phone',
        'address',
        'hire_date',
        'salary',
        'status',
        'profile_picture',
        'company_id', 
    ];
    

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    protected static function booted(): void
        {
            parent::booted();

            // pour filtrer les employés par company_id
            static::addGlobalScope(new CompanyScope);

            // Attribution automatique de company_id à la création
            static::creating(function ($employee) {
                if (auth()->check()) {
                    $employee->company_id = auth()->user()->company_id;
                }
            });
        }

}
