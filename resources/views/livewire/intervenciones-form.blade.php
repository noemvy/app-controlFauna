<div class="space-y-4">
    <x-filament::input.label for="tipo" value="Tipo de intervención" />
    <x-filament::input wire:model="tipo" id="tipo" />

    <x-filament::input.label for="descripcion" value="Descripción" />
    <x-filament::textarea wire:model="descripcion" id="descripcion" />

    <x-filament::button color="primary" wire:click="save">
        Guardar intervención
    </x-filament::button>
</div>
