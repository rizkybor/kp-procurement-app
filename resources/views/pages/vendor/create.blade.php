<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <!-- Sidebar -->
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Create Vendor</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Add a new vendor with company details, PIC, and supporting documents.
                    </p>
                </div>
            </div>

            <!-- Form -->
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form method="POST" action="{{ route('vendors.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="grid grid-cols-1 gap-y-6">

                            {{-- Company Info --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="name">Name <span class="text-red-500">*</span></x-label>
                                    <x-input id="name" name="name" type="text" class="mt-1 block w-full"
                                             value="{{ old('name') }}" required placeholder="Company name"/>
                                    <x-input-error for="name" class="mt-2"/>
                                </div>

                                <div>
                                    <x-label for="business_type">Business Type</x-label>
                                    @if(!empty($businessTypes) && count($businessTypes))
                                        <select id="business_type" name="business_type"
                                                class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm">
                                            <option value="">Select business type</option>
                                            @foreach($businessTypes as $bt)
                                                <option value="{{ $bt }}" @selected(old('business_type')===$bt)>{{ $bt }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <x-input id="business_type" name="business_type" type="text"
                                                 class="mt-1 block w-full"
                                                 value="{{ old('business_type') }}" placeholder="Individual / Corporate"/>
                                    @endif
                                    <x-input-error for="business_type" class="mt-2"/>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="tax_number">Tax Number</x-label>
                                    <x-input id="tax_number" name="tax_number" type="text" class="mt-1 block w-full"
                                             value="{{ old('tax_number') }}" placeholder="##.###.###.#-###.###"/>
                                    <x-input-error for="tax_number" class="mt-2"/>
                                </div>

                                <div>
                                    <x-label for="company_address">Company Address</x-label>
                                    <textarea id="company_address" name="company_address" rows="2"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-white dark:bg-gray-900">{{ old('company_address') }}</textarea>
                                    <x-input-error for="company_address" class="mt-2"/>
                                </div>
                            </div>

                            {{-- Business Fields (JSON array) --}}
                            <div>
                                <x-label for="business_fields">Business Fields</x-label>
                                <input id="business_fields" name="business_fields[]"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       placeholder="e.g. Material Procurement, Logistics"
                                       value="{{ is_array(old('business_fields')) ? implode(', ', old('business_fields')) : '' }}"
                                       oninput="/* optional: turn into chips later */">
                                <p class="text-xs text-gray-500 mt-1">Separate with comma. Will be saved as an array.</p>
                                {{-- You can also swap to tag input or checkboxes; controller expects array --}}
                            </div>

                            {{-- PIC --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="pic_name">PIC Name</x-label>
                                    <x-input id="pic_name" name="pic_name" type="text" class="mt-1 block w-full"
                                             value="{{ old('pic_name') }}" placeholder="Person in charge"/>
                                    <x-input-error for="pic_name" class="mt-2"/>
                                </div>
                                <div>
                                    <x-label for="pic_position">PIC Position</x-label>
                                    <x-input id="pic_position" name="pic_position" type="text" class="mt-1 block w-full"
                                             value="{{ old('pic_position') }}" placeholder="Director / Manager / Owner"/>
                                    <x-input-error for="pic_position" class="mt-2"/>
                                </div>
                            </div>

                            {{-- Documents --}}
                            <div class="pt-2">
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Documents</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <x-label for="file_deed_of_company">Deed of Company (PDF/JPG/PNG, max 5MB)</x-label>
                                        <input id="file_deed_of_company" name="file_deed_of_company" type="file"
                                               class="mt-1 block w-full">
                                        <x-input-error for="file_deed_of_company" class="mt-2"/>
                                    </div>
                                    <div>
                                        <x-label for="file_legalization_letter">Legalization Letter</x-label>
                                        <input id="file_legalization_letter" name="file_legalization_letter" type="file"
                                               class="mt-1 block w-full">
                                        <x-input-error for="file_legalization_letter" class="mt-2"/>
                                    </div>

                                    <div>
                                        <x-label for="file_nib">NIB</x-label>
                                        <input id="file_nib" name="file_nib" type="file" class="mt-1 block w-full">
                                        <x-input-error for="file_nib" class="mt-2"/>
                                    </div>
                                    <div>
                                        <x-label for="file_siujk">SIUJK</x-label>
                                        <input id="file_siujk" name="file_siujk" type="file" class="mt-1 block w-full">
                                        <x-input-error for="file_siujk" class="mt-2"/>
                                    </div>

                                    <div>
                                        <x-label for="file_tax_registration">Tax Registration (NPWP)</x-label>
                                        <input id="file_tax_registration" name="file_tax_registration" type="file"
                                               class="mt-1 block w-full">
                                        <x-input-error for="file_tax_registration" class="mt-2"/>
                                    </div>
                                    <div>
                                        <x-label for="file_vat_registration">VAT Registration (PKP)</x-label>
                                        <input id="file_vat_registration" name="file_vat_registration" type="file"
                                               class="mt-1 block w-full">
                                        <x-input-error for="file_vat_registration" class="mt-2"/>
                                    </div>

                                    <div>
                                        <x-label for="file_id_card">ID Card (KTP)</x-label>
                                        <input id="file_id_card" name="file_id_card" type="file" class="mt-1 block w-full">
                                        <x-input-error for="file_id_card" class="mt-2"/>
                                    </div>
                                    <div>
                                        <x-label for="file_vendor_statement">Vendor Statement</x-label>
                                        <input id="file_vendor_statement" name="file_vendor_statement" type="file"
                                               class="mt-1 block w-full">
                                        <x-input-error for="file_vendor_statement" class="mt-2"/>
                                    </div>

                                    <div>
                                        <x-label for="file_integrity_pact">Integrity Pact</x-label>
                                        <input id="file_integrity_pact" name="file_integrity_pact" type="file"
                                               class="mt-1 block w-full">
                                        <x-input-error for="file_integrity_pact" class="mt-2"/>
                                    </div>
                                    <div>
                                        <x-label for="file_vendor_feasibility">Vendor Feasibility</x-label>
                                        <input id="file_vendor_feasibility" name="file_vendor_feasibility" type="file"
                                               class="mt-1 block w-full">
                                        <x-input-error for="file_vendor_feasibility" class="mt-2"/>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <x-label for="file_interest_statement">Interest Statement</x-label>
                                        <input id="file_interest_statement" name="file_interest_statement" type="file"
                                               class="mt-1 block w-full">
                                        <x-input-error for="file_interest_statement" class="mt-2"/>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('vendors.page') }}"
                               class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600">
                                Back
                            </a>
                            <x-button>Save Vendor</x-button>
                        </div>
                    </div>
                </form>

                <x-validation-errors class="mt-4"/>
            </div>
        </div>
    </div>
</x-app-layout>