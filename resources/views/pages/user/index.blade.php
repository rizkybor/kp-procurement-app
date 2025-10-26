<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

  <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Daftar Semua Pengguna</h1>

            <x-link-button href="{{ route('register') }}"  style="background-color: rgb(86, 167, 196)">
                + Tambah Akun
            </x-link-button>
        </div>
        <!-- Card -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
                <header
                    class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="font-semibold dark:text-gray-100 py-3">Pengguna</h2>

                    <form method="GET" action="{{ route('users.index') }}" class="flex gap-2">
                        <input type="text" name="search" placeholder="Search name/email/department..."
                            class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-200 font-medium px-3 py-2 h-9 rounded-lg shadow-sm focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 transition-all"
                            value="{{ request('search') }}" />
                        <x-button type="submit"
style="background-color: rgb(175, 175, 78)"
                            class="bg-blue-600 text-white px-4 py-2 h-9 rounded-lg shadow hover:bg-blue-700 transition-all">
                            Search
                        </x-button>
                    </form>
                </header>

                <!-- Table -->
                <div class="p-3 overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead
                            class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50">
                            <tr>
                                <th class="p-2 text-left">#</th>
                                <th class="p-2 text-left">Nama</th>
                                <th class="p-2 text-left">Email</th>
                                <th class="p-2 text-left">Departemen</th>
                                <th class="p-2 text-left">Posisi</th>
                                <th class="p-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="p-2 text-sm">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td class="p-2 text-sm">{{ $user->name }}</td>
                                    <td class="p-2 text-sm">{{ $user->email }}</td>
                                    <td class="p-2 text-sm">{{ $user->department ?? '-' }}</td>
                                    <td class="p-2 text-sm">{{ $user->position ?? '-' }}</td>
                                    <td class="p-2 text-sm">
                                        <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">Edit</a>
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm ml-2">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>