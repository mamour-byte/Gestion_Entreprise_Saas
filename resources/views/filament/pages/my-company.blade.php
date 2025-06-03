<x-filament::page>
    <h2 class="text-2xl font-bold mb-4">Mon Entreprise</h2>

    @php
        $company = auth()->user()->company;
    @endphp

    <div class="space-y-2">
        <p><strong>Nom :</strong> {{ $company->name }}</p>
    </div>
</x-filament::page>
