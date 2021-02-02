<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send a Message') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('messages.store') }}">
                <input type="hidden" name="listing_id" value="{{ request('listing_id') }}" />
                @csrf

                <div>
                    <x-jet-label for="message" value="{{ __('Message') }}" />
                    <textarea required name="message" rows="10" class="block mt-1 w-full"></textarea>
                </div>

                <div class="flex items-center mt-6">
                    <x-jet-button>
                        {{ __('Send message') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
