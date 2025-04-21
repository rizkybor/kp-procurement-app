<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <!-- Left: Title -->
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                Dokumen Pengadaan
            </h1>

            <!-- Right: Buttons -->
            <div class="flex gap-2 mt-4 sm:mt-0">
                <x-button.button-action color="purple" id="exportSelected">
                    Export Selected
                </x-button.button-action>
                <x-button.button-action color="teal" type="button"
                    onclick="window.location='{{ route('work_request.create') }}'">
                    + Data Baru
                </x-button.button-action>
            </div>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">

            <!-- Card (Customers) -->
            {{-- <x-documents.table-index :workRequest="$workRequest" /> --}}
            <div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
                <header
                    class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="font-semibold dark:text-gray-100 py-3">Procurement</h2>
                </header>
                <div class="p-3">
                    <!-- Table Controls -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                        <div class="relative">
                            <input type="search" id="searchTable"
                                class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 
                                text-sm text-gray-700 dark:text-gray-200 font-medium px-3 pr-10 py-2 h-9 rounded-lg shadow-sm 
                                focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 transition-all ease-in-out duration-200"
                                placeholder="Search...">
                        </div>

                        <!-- Show Entries Dropdown (Hidden on Mobile) -->
                        <div class="hidden sm:flex items-center gap-2">
                            <label for="perPage"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">Show:</label>
                            <select id="perPage"
                                class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 
                                text-sm text-gray-700 dark:text-gray-200 font-medium px-3 pr-8 py-2 h-9 rounded-lg shadow-sm 
                                focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 transition-all ease-in-out duration-200">
                                <option value="10">10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table id="WorkRequestTable" class="table-auto w-full">
                            <thead
                                class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50">
                                <tr>
                                    <th class="p-2 whitespace-nowrap"><input type="checkbox" id="selectAll"
                                            class="form-checkbox h-5 w-5 text-blue-600"></th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">No</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Nama Pekerjaan</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Judul Proyek</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Pemilik Proyek</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">No. Kontrak</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Nomor</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Tanggal</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">PIC</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Total RAB</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Action</div>
                                    </th>

                                </tr>
                            </thead>
                        </table>
                    </div>

                    <!-- Show Entries Dropdown (Visible only on Mobile) -->
                    <div class="flex items-center gap-2 sm:hidden mt-5">
                        <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300">Show:</label>
                        <select id="perPage"
                            class="border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 
                            text-sm text-gray-700 dark:text-gray-200 font-medium px-3 pr-8 py-2 h-9 rounded-lg shadow-sm 
                            focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 transition-all ease-in-out duration-200">
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                    <!-- Pagination di bawah table -->
                    <div class="mt-1 flex flex-col sm:flex-row sm:items-center justify-between">
                        <div id="tableInfo" class="text-sm text-gray-500 dark:text-gray-400"></div>
                        <div id="tablePagination"></div>
                    </div>
                </div>

            </div>


        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js"></script>
    <script>
        moment.locale('id'); // Setel bahasa ke Bahasa Indonesia
    </script>

    <script>
        $(document).ready(function() {
            let table = $('#WorkRequestTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('work_request.datatable') }}",
                pageLength: 10,
                lengthChange: false,
                searching: true,
                dom: 'rtip',
                pagingType: "simple",
                responsive: true,
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        className: 'p-2 whitespace-nowrap',
                        render: function(data) {
                            return `<input type="checkbox" class="rowCheckbox form-checkbox h-5 w-5 text-blue-600" value="${data}">`;
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'p-2 whitespace-nowrap text-sm',
                    },
                    {
                        data: 'project_title',
                        name: 'project_title',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            return `<div>${data ?? '-'}</div>`;
                        }
                    },
                    {
                        data: 'work_name_request',
                        name: 'work_name_request',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            return `<div>${data ?? '-'}</div>`;
                        }
                    },
                    {
                        data: 'project_owner',
                        name: 'project_owner',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            return `<div>${data ?? '-'}</div>`;
                        }
                    },
                    {
                        data: 'contract_number',
                        name: 'contract_number',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            return `<div>${data ?? '-'}</div>`;
                        }
                    },
                    {
                        data: 'request_number',
                        name: 'request_number',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            return `<div>${data ?? '-'}</div>`;
                        }
                    },
                    {
                        data: 'request_date',
                        name: 'request_date',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            return `<div>${data ?? '-'}</div>`;
                        }
                    },
                    {
                        data: 'pic',
                        name: 'pic',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            return `<div>${data ?? '-'}</div>`;
                        }
                    },
                    {
                        data: 'total_rab',
                        name: 'total_rab',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            return `<div>${data ?? '-'}</div>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'p-2 whitespace-nowrap text-center',
                        render: function(data, type, row) {
                            let detailUrl =
                                "{{ route('work_request.work_request_items.show', ['id' => '__ID__']) }}"
                                .replace('__ID__', row.id);
                            let editUrl =
                                "{{ route('work_request.work_request_items.edit', ['id' => '__ID__']) }}"
                                .replace('__ID__', row.id);
                            let deleteUrl =
                                "{{ route('work_request.destroy', ['id' => '__ID__']) }}".replace(
                                    '__ID__', row.id);

                            return `
                            <div class="text-center flex items-center justify-center gap-2">
    <!-- View Button -->
    <button class="bg-teal-500 text-white p-2 rounded-lg hover:bg-teal-600 transition-all duration-200"
        onclick="window.location.href='${detailUrl}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
    </button>

    <!-- Edit Button -->
    <button class="bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600 transition-all duration-200"
        onclick="window.location.href='${editUrl}'">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
    </button>

    <!-- Delete Button -->
    <form action="${deleteUrl}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
        <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-all duration-200"
            type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        </button>
    </form>
</div>
      `;
                        }
                    }
                ],
                infoCallback: function(settings, start, end, max, total, pre) {
                    return `
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Showing <span class="font-medium">${start}</span> to
                    <span class="font-medium">${end}</span> of
                    <span class="font-medium">${total}</span> documents
                </p>
            `;
                },
                drawCallback: function(settings) {
                    let pageInfo = table.page.info();
                    let currentPage = pageInfo.page + 1;
                    let totalPages = pageInfo.pages;

                    let paginationHtml = `
                <div class="flex justify-center">
                    <nav class="flex" role="navigation" aria-label="Navigation">
                        <div class="mr-2">
                            ${currentPage > 1 ? `
                                                                                                                                                                                                                    <button onclick="table.page(${currentPage - 2}).draw(false)" 
                                                                                                                                                                                                                        class="inline-flex items-center justify-center rounded-lg leading-5 px-2.5 py-2 bg-white dark:bg-gray-800 
                                                                                                                                                                                                                        border border-gray-200 dark:border-gray-700/60 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 shadow-sm">
                                                                                                                                                                                                                        <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16">
                                                                                                                                                                                                                            <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z" />
                                                                                                                                                                                                                        </svg>
                                                                                                                                                                                                                    </button>` : `
                                                                                                                                                                                                                    <span class="inline-flex items-center justify-center rounded-lg leading-5 px-2.5 py-2 bg-white dark:bg-gray-800 
                                                                                                                                                                                                                        border border-gray-200 dark:border-gray-700/60 text-gray-300 dark:text-gray-600 shadow-sm">
                                                                                                                                                                                                                        <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16">
                                                                                                                                                                                                                            <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z" />
                                                                                                                                                                                                                        </svg>
                                                                                                                                                                                                                    </span>`}
                        </div>
                        <ul class="inline-flex text-sm font-medium -space-x-px rounded-lg shadow-sm">`;

                    for (let i = 1; i <= totalPages; i++) {
                        if (i === currentPage) {
                            paginationHtml += `
                        <li>
                            <span class="inline-flex items-center justify-center rounded-lg leading-5 px-3.5 py-2 bg-white dark:bg-gray-800 
                                border border-gray-200 dark:border-gray-700/60 text-violet-500">
                                ${i}
                            </span>
                        </li>`;
                        } else {
                            paginationHtml += `
                        <li>
                            <button onclick="table.page(${i - 1}).draw(false)" 
                                class="inline-flex items-center justify-center leading-5 px-3.5 py-2 bg-white dark:bg-gray-800 
                                hover:bg-gray-50 dark:hover:bg-gray-900 border border-gray-200 dark:border-gray-700/60 
                                text-gray-600 dark:text-gray-300">
                                ${i}
                            </button>
                        </li>`;
                        }
                    }

                    paginationHtml += `
                        </ul>
                        <div class="ml-2">
                            ${currentPage < totalPages ? `
                                                                                                                                                                                                                    <button onclick="table.page(${currentPage}).draw(false)" 
                                                                                                                                                                                                                        class="inline-flex items-center justify-center rounded-lg leading-5 px-2.5 py-2 bg-white dark:bg-gray-800 
                                                                                                                                                                                                                        border border-gray-200 dark:border-gray-700/60 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 shadow-sm">
                                                                                                                                                                                                                        <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16">
                                                                                                                                                                                                                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                                                                                                                                                                                                                        </svg>
                                                                                                                                                                                                                    </button>` : `
                                                                                                                                                                                                                    <span class="inline-flex items-center justify-center rounded-lg leading-5 px-2.5 py-2 bg-white dark:bg-gray-800 
                                                                                                                                                                                                                        border border-gray-200 dark:border-gray-700/60 text-gray-300 dark:text-gray-600 shadow-sm">
                                                                                                                                                                                                                        <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16">
                                                                                                                                                                                                                            <path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" />
                                                                                                                                                                                                                        </svg>
                                                                                                                                                                                                                    </span>`}
                        </div>
                    </nav>
                </div>`;

                    $('#tablePagination').html(paginationHtml);
                }
            });

            // Export Selected
            $('#exportSelected').on('click', function() {
                let selected = [];
                $('.rowCheckbox:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length === 0) {
                    alert("Pilih minimal satu data untuk diexport!");
                    return;
                }


                let url = "{{ route('work_request.export') }}?ids=" + encodeURIComponent(selected.join(
                    ","));
                window.open(url, '_blank');
            });

            // Custom Search Bar
            $('#searchTable').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Custom Dropdown Entries
            $('#perPage').on('change', function() {
                table.page.len($(this).val()).draw();
            });

            // Checkbox Select All
            $('#selectAll').on('click', function() {
                let rows = table.rows({
                    search: 'applied'
                }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });
        });
    </script>
</x-app-layout>
