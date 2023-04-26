<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Mailbox') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
        <div class="w-1/6">
            <div class="grid">
                <a href="{{ route('mailbox.compose') }}" class="bg-indigo-500 text-white rounded py-2 px-4 font-semibold">Compose</a>
            </div>

            <div class="mt-3">
                <x-mail-nav-link href="{{ route('mailbox.inbox') }}" :active="request()->routeIs('mailbox.inbox')">
                    {{ __('Inbox') }}
                </x-mail-nav-link>
                <x-mail-nav-link href="{{ route('mailbox.drafts') }}" :active="request()->routeIs('mailbox.drafts')">
                    {{ __('Drafts') }}
                </x-mail-nav-link>
                <x-mail-nav-link href="{{ route('mailbox.send-mail') }}" :active="request()->routeIs('mailbox.send-mail')">
                    {{ __('Send Mail') }}
                </x-mail-nav-link>
                <x-mail-nav-link href="{{ route('mailbox.trash') }}" :active="request()->routeIs('mailbox.trash')">
                    {{ __('Trash') }}
                </x-mail-nav-link>
            </div>
        </div>

        <div class="w-5/6">
            <div class="bg-white shadow-md rounded-lg py-4 px-4 ml-10">

                <form>

                    <!-- Email -->
                    <div class="col-span-6 sm:col-span-4 mt-2">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email" autocomplete="email" />
                        <x-input-error for="email" class="mt-2" />
                    </div>

                    <!-- Subject -->
                    <div class="col-span-6 sm:col-span-4 mt-2">
                        <x-label for="subject" value="{{ __('Subject') }}" />
                        <x-input id="subject" type="text" class="mt-1 block w-full" wire:model.defer="subject" autocomplete="subject" />
                        <x-input-error for="subject" class="mt-2" />
                    </div>

                    <!-- Body -->
                    <div class="col-span-6 sm:col-span-4 mt-2">
                        <x-label for="body" value="{{ __('Body') }}" />
                        <textarea id="body" class="mt-1 block w-full" rows="4" wire:model.defer="body" autocomplete="body"></textarea>
                        <x-input-error for="name" class="mt-2" />
                    </div>


                    <x-button class="mt-2"  wire:click.prevent="send()">
                        {{ __('Save') }}
                    </x-button>

                </form>

            </div>
        </div>
    </div>
</div>