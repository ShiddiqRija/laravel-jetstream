<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Mailbox') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
        <div class="w-1/6">
            <div class="grid">
                <a href="email-compose.html" class="bg-indigo-500 text-white rounded py-2 px-4 font-semibold">Compose</a>
            </div>

            <div class="mt-3">
                <x-mail-nav-link href="{{ route('mailbox.inbox') }}" :active="request()->routeIs('mailbox.inbox.*')">
                    {{ __('Inbox') }}
                </x-mail-nav-link>
                <x-mail-nav-link href="{{ route('mailbox.draft') }}" :active="request()->routeIs('mailbox.draft')">
                    {{ __('Draft') }}
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
            <div class="bg-white shadow-md rounded-lg py-4 ml-10 p-6 lg:p-8">

                <div class="flex items-center">
                    <h2 class="text-xl font-semibold text-gray-900">
                        {{ $subject }}
                    </h2>
                </div>

                <p class="mt-2 text-sm font-small text-gray-900">
                    From : {{ $sender }}
                </p>

                <div class="mt-2">
                    <hr />
                </div>

                <div class="mt-3">
                    {!! $mailBody !!}
                </div>

            </div>

        </div>
    </div>
</div>