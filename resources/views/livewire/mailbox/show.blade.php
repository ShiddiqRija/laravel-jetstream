<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Mailbox') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
        <div class="w-1/6">
            <div class="grid">
                <a href="{{ route('mailbox.compose') }}"
                    class="bg-indigo-500 text-white rounded py-2 px-4 font-semibold">Compose</a>
            </div>

            <div class="mt-3">
                <x-mail-nav-link href="{{ route('mailbox.inbox') }}" :active="request()->routeIs('mailbox.inbox.*')">
                    {{ __('Inbox') }}
                </x-mail-nav-link>
                <x-mail-nav-link href="{{ route('mailbox.drafts') }}" :active="request()->routeIs('mailbox.drafts.*')">
                    {{ __('Draft') }}
                </x-mail-nav-link>
                <x-mail-nav-link href="{{ route('mailbox.send-mail') }}" :active="request()->routeIs('mailbox.send-mail.*')">
                    {{ __('Send Mail') }}
                </x-mail-nav-link>
                <x-mail-nav-link href="{{ route('mailbox.trash') }}" :active="request()->routeIs('mailbox.trash.*')">
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

                <div class="flex items-center justify-between sm:flex-wrap gap-[15px]">
                    <div class="flex items-center gap-5 mt-5">
                        <div>
                            <h1 class="sc-hAZoDl iwMyeL mb-1 text-base font-medium text-dark dark:text-white87">
                                {{ $sender }}
                            </h1>
                            <a class="ant-dropdown-trigger flex items-center gap-[5px] text-light dark:text-white60 sc-dmRaPn iSEuXB" href="#">To me
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center xs:flex-wrap xs:gap-[10px]">
                        <span class="text-light dark:text-white60 min-xs:ltr:mr-[15px] min-xs:rtl:ml-[15px]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M18.08,12.42,11.9,18.61a4.25,4.25,0,0,1-6-6l8-8a2.57,2.57,0,0,1,3.54,0,2.52,2.52,0,0,1,0,3.54l-6.9,6.89A.75.75,0,1,1,9.42,14l5.13-5.12a1,1,0,0,0-1.42-1.42L8,12.6a2.74,2.74,0,0,0,0,3.89,2.82,2.82,0,0,0,3.89,0l6.89-6.9a4.5,4.5,0,0,0-6.36-6.36l-8,8A6.25,6.25,0,0,0,13.31,20l6.19-6.18a1,1,0,1,0-1.42-1.42Z"></path>
                            </svg>
                        </span>
                        <span class="text-light px-7"> March 25, 2020 1:34 PM </span>
                        <a class="min-xs:px-[15px] text-light dark:text-white60" href="/hexadash-tailwind/admin/email/single/1585118055048">
                            <span aria-hidden="true" class="fa fa-star-o w-4 h-4"></span>
                        </a>
                        <a class="px-2" href="{{ route('mailbox.reply', ['folder' => $folder, 'id' => $id])}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M14.69,6.63h-7l2.92-2.92a1,1,0,0,0,0-1.42,1,1,0,0,0-1.41,0L4.61,6.92a1,1,0,0,0-.22.33,1,1,0,0,0,0,.76,1.19,1.19,0,0,0,.22.33L9.24,13a1,1,0,0,0,.7.3,1,1,0,0,0,.71-1.71L7.73,8.63h7a3,3,0,0,1,3,3V21a1,1,0,0,0,2,0V11.63A5,5,0,0,0,14.69,6.63Z"></path>
                            </svg>
                        </a>
                        <a class="px-2" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M12,7a2,2,0,1,0-2-2A2,2,0,0,0,12,7Zm0,10a2,2,0,1,0,2,2A2,2,0,0,0,12,17Zm0-7a2,2,0,1,0,2,2A2,2,0,0,0,12,10Z"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <hr />
                </div>

                <div id="email-view" class="mt-3">
                </div>

            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script>
        function displayData(dataHtml) {
            var container = document.querySelector('#email-view');
            var shadow = container.attachShadow({
                mode: 'open'
            });

            var style = document.createElement('style');
            style.textContent = dataCss;
            shadow.appendChild(style);

            var html = document.createElement('div');
            html.innerHTML = dataHtml;
            shadow.appendChild(html);
        }

        var dataHtml = `{!! $htmlEmail !!}`;
        var dataCss = `{!! $cssEmail !!}`;
        displayData(dataHtml, dataCss);
        console.log('jalan')
    </script>
