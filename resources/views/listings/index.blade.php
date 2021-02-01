<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('listings.create') }}"
               class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">{{ __('Add new listing') }}</a>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Categories
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sizes
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Colors
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th class="relative px-6 py-3" colspan="2"></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($listings as $listing)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ $listing->getFirstMediaUrl('listings', 'thumb') }}" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach ($listing->categories as $category)
                                    {{ $category->name }}
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach ($listing->sizes as $size)
                                    {{ $size->name }}
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach ($listing->colors as $color)
                                    {{ $color->name }}
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">${{ $listing->price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @can('update', $listing)
                                    <a href="{{ route('listings.edit', $listing) }}"
                                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Edit</a>
                                @endcan
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @can('delete', $listing)
                                    <form method="POST" action="{{ route('listings.destroy', $listing) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-jet-danger-button onclick="return confirm('Are you sure?')" type="submit">
                                            Delete
                                        </x-jet-danger-button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
