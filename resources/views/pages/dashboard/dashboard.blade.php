<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <!-- Left: Title -->
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                Beranda
            </h1>

            <!-- Right: Buttons -->
            <div class="flex gap-2 mt-4 sm:mt-0">
            </div>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">

            <!-- Card (Customers) -->
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
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-left">No</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Judul Proyek</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Pemilik Proyek</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Status</div>
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
                                        <div class="font-semibold text-center">Tenggat</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class="font-semibold text-center">Total RAB</div>
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
                language: {
                    paginate: {
                        previous: '',
                        next: '',
                    }
                },
                columns: [{
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
                        data: 'project_owner',
                        name: 'project_owner',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            return `<div>${data ?? '-'}</div>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        orderable: false,
                        searchable: true,
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
                            if (!data) return '-';

                            const date = new Date(data);
                            const options = {
                                year: 'numeric',
                                month: 'long',
                                day: '2-digit'
                            };

                            return new Intl.DateTimeFormat('id-ID', options).format(date);
                        }
                    },
                    {
                        data: 'deadline',
                        name: 'deadline',
                        className: 'p-2 whitespace-nowrap text-center text-sm',
                        render: function(data) {
                            if (!data) return '-';

                            const date = new Date(data);
                            const options = {
                                year: 'numeric',
                                month: 'long',
                                day: '2-digit'
                            };

                            return new Intl.DateTimeFormat('id-ID', options).format(date);
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
                    let api = this.api();
                    let pageInfo = api.page.info();
                    let currentPage = pageInfo.page + 1;
                    let totalPages = pageInfo.pages;


                    // Generate pagination controls
                    let paginationHtml = `
        <div class="flex justify-center">
            <nav class="flex" role="navigation" aria-label="Navigation">
                <div class="mr-2">
                    ${currentPage > 1 ? `
                                                                                                                        <button data-page="${currentPage - 2}" 
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

                    // Generate page numbers
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
                    <button data-page="${i - 1}" 
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
                                                                                                                <button data-page="${currentPage}" 
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

                    // Update pagination container
                    $('#tablePagination').html(paginationHtml);

                    $('#tablePagination').off('click', 'button[data-page]').on('click',
                        'button[data-page]',
                        function() {
                            let page = $(this).data('page');
                            table.page(page).draw('page');
                        });
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
