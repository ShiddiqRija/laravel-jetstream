<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Mailbox') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
        <div class="w-1/6">
            <div class="grid">
                <a href="#" class="bg-indigo-500 text-white rounded py-2 px-4 font-semibold">Compose</a>
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
            <div class="bg-white shadow-md rounded-lg py-4 ml-10">

                <table class="table-fixed w-full ">
                    <tbody class="bg-red">
                        @if($messages->count() > 0)
                        @foreach($messages as $message)
                        <tr wire:click="openEmail('{{ $folder }}', {{ $message->uid }})" class="hover:bg-gray-300 cursor-pointer">
                            <td class="px-2 py-2 font-medium text-sm w-2/12">{{ substr($message->getFrom()[0]->personal, 0, 19) . '.' }}</td>
                            <td class="px-2 py-2 text-sm w-8/12">{!! substr($message->getSubject() . ' &nbsp;&ndash;&nbsp; <span class="text-gray-600">' . $message->mailText, 0, 140) . '...' . '</span>'!!}</td>
                            <td class="px-2 py-2 text-sm w-1/12 text-right">{{ $message->date }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="2" class="font-medium text-center text-large">No Email</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

            </div>

            <div class="py-4 ml-10">
                {{$messages->links()}}
            </div>
        </div>
    </div>
</div>