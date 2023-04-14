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
                <x-mail-nav-link href="{{ route('mailbox.inbox') }}" :active="request()->routeIs('mailbox.inbox')">
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

        <div class="w-full">
            <div class="bg-white shadow-md rounded-lg py-4 ml-10">
                <ul class="message-list">

                    <a href="#">
                        <li class="unread flex items-center justify-between hover:bg-gray-300 py-3 px-4">

                            <div class="flex items-center">
                                <div class="checkbox-wrapper-mail mr-2">
                                    <input type="checkbox" id="chk19" />
                                    <label for="chk19" class="toggle"></label>
                                </div>
                                <span class="font-medium">Peter, me (3)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="font-medium">Hello &nbsp;–&nbsp;</span>
                                <span class="text-gray-500">Trip home from Colombo has been arranged, then Jenna will come get me from Stockholm. :)</span>
                                <span class="ml-2 text-gray-500">Mar 6</span>
                            </div>
                        </li>
                    </a>

                    <a href="#">
                        <li class="unread flex items-center justify-between hover:bg-gray-300 py-3 px-4">

                            <div class="flex items-center">
                                <div class="checkbox-wrapper-mail mr-2">
                                    <input type="checkbox" id="chk19" />
                                    <label for="chk19" class="toggle"></label>
                                </div>
                                <span class="font-medium">Peter, me (3)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="font-medium">Hello &nbsp;–&nbsp;</span>
                                <span class="text-gray-500">Trip home from Colombo has been arranged, then Jenna will come get me from Stockholm. :)</span>
                                <span class="ml-2 text-gray-500">Mar 6</span>
                            </div>
                        </li>
                    </a>

                    <a href="#">
                        <li class="unread flex items-center justify-between hover:bg-gray-300 py-3 px-4">

                            <div class="flex items-center">
                                <div class="checkbox-wrapper-mail mr-2">
                                    <input type="checkbox" id="chk19" />
                                    <label for="chk19" class="toggle"></label>
                                </div>
                                <span class="font-medium">Peter, me (3)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="font-medium">Hello &nbsp;–&nbsp;</span>
                                <span class="text-gray-500">Trip home from Colombo has been arranged, then Jenna will come get me from Stockholm. :)</span>
                                <span class="ml-2 text-gray-500">Mar 6</span>
                            </div>
                        </li>
                    </a>

                </ul>
            </div>

            <div class="flex items-center justify-between mt-3 ml-10">
                <div class="text-sm text-gray-700">Showing 1 - 20 of 1,524</div>
                <div class="btn-group">
                    <button type="button" class="py-1 px-2 rounded-md bg-green-500 text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-opacity-50">
                        <svg class="w-6 h-6 stroke-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 8L10 12L14 16" stroke="stroke-white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button type="button" class="py-1 px-2 rounded-md bg-green-500 text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-opacity-50">
                        <svg class="w-6 h-6 stroke-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 16L14 12L10 8" stroke="stroke-white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>