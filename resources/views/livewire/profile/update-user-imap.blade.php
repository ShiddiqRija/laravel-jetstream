<x-form-section submit="update({{Auth::user()->id}})">
    <x-slot name="title">
        {{ __('Update User IMAP') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a corret password to connect to Email IMAP.') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">
            <x-label for="imap_host" value="{{ __('IMAP Host') }}" />
            <x-input id="imap_host" type="text" class="mt-1 block w-full" wire:model.defer="imap_host" autocomplete="imap-host" />
            <x-input-error for="imap_host" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="imap_password" value="{{ __('IMAP Password') }}" />
            <x-input id="imap_password" type="password" class="mt-1 block w-full" wire:model.defer="imap_password" autocomplete="imap-password" />
            <x-input-error for="imap_password" class="mt-2" />
        </div>

    </x-slot>
    

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }} 
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>