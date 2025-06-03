<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;

class MyCompany extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Mon entreprise';
    protected static ?string $title = 'Mon entreprise';
    protected static string $view = 'filament.pages.my-company';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getCompany()?->toArray());
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email(),
            Forms\Components\TextInput::make('phone'),
            Forms\Components\TextInput::make('address'),
        ];
    }

    public function getCompany()
    {
        return Auth::user()->company;
    }

    public function save(): void
    {
        $company = $this->getCompany();
        $company->update($this->form->getState());
        $this->notify('success', 'Informations mises à jour');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }
}

