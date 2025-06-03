<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MyCompany extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static string $view = 'filament.pages.my-company';

    protected static ?string $navigationLabel = 'Mon Entreprise';
    protected static ?string $navigationGroup = 'Paramètres';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->company_id !== null;
    }

    public function getCompany()
    {
        return auth()->user()->company;
    }
}
