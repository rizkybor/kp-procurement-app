<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">List All Vendors</h1>

            <a href="{{ route('vendors.create') }}"
               class="mt-3 sm:mt-0 inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 h-10 rounded-lg shadow transition-all duration-200">
                + Add New Vendor
            </a>
        </div>

        <!-- Card -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
                <header
                    class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="font-semibold dark:text-gray-100 py-3">Vendors</h2>

                    <form method="GET" action="{{ route('vendors.page') }}" class="flex gap-2">
                        <input type="text" name="search" placeholder="Search name/type/address..."
                               class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-200 font-medium px-3 py-2 h-9 rounded-lg shadow-sm focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 transition-all"
                               value="{{ request('search') }}" />
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 h-9 rounded-lg shadow hover:bg-blue-700 transition-all">
                            Search
                        </button>
                    </form>
                </header>

                <!-- Table -->
                <div class="p-3 overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap text-left">#</th>
                                <th class="p-2 whitespace-nowrap text-left">Name</th>
                                <th class="p-2 whitespace-nowrap text-left">Address</th>
                                <th class="p-2 whitespace-nowrap text-left">Business Type</th>
                                <th class="p-2 whitespace-nowrap text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($vendors as $index => $vendor)
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="p-2 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $loop->iteration + ($vendors->currentPage() - 1) * $vendors->perPage() }}
                                </td>
                                <td class="p-2 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $vendor->name }}
                                </td>
                                <td class="p-2 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $vendor->company_address }}
                                </td>
                                <td class="p-2 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $vendor->business_type ?? '-' }}
                                </td>
                                <td class="p-2 text-sm text-gray-700 dark:text-gray-200">
                                    <a href="{{ route('vendors.edit', $vendor) }}"
                                       class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this vendor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-semibold text-sm ml-2">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">
                                    No vendors found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $vendors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>