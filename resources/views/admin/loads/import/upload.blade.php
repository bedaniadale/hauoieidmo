<x-app-layout>
    <div class="w-full flex items-center justify-center py-8 bg-gray-100">
        <div class="w-[95%] bg-white rounded-lg shadow-md px-6 py-8">
            @if(!$imported)
                {{-- File Upload Form --}}
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Upload Your File</h2>
                <form action="{{ route('admin.loads.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('POST')

                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Select File</label>
                        <input type="file" name="file" id="file" 
                               class="block w-full text-gray-700  rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <button type="submit" 
                            class="w-full bg-red-900 text-white py-2 px-4 rounded-lg hover:bg-red-800 transition shadow-sm">
                        Upload File
                    </button>
                </form>
            @else
                {{-- Confirmation with Table --}}
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Review Uploaded Data</h2>
                <p class="text-gray-600 mb-4">Upon review, the following teaching loads have passed the evaluation and are ready to be loaded:</p>

                {{-- Data Table --}}
                <div class="overflow-hidden rounded-lg border border-gray-300">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
                            <tr>
                                <th class="text-left py-3 px-4">#</th>
                                <th class="text-left py-3 px-4">EMP ID</th>
                                <th class="text-left py-3 px-4">FULL NAME</th>
                                <th class="text-left py-3 px-4">SUBJECT</th>
                                <th class="text-left py-3 px-4">CLASS CODE</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @foreach($loads->take(6) as $index => $load) <!-- Limit to 6 items -->
                                <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4">{{ $load->emp_id }}</td>
                                    <td class="py-3 px-4">{{ $load->user->emp_lname . ', ' . $load->user->emp_fname . ' ' . $load->user->emp_mname }}</td>
                                    <td class="py-3 px-4">{{ $load->subject->subj_code }}</td>
                                    <td class="py-3 px-4">{{ $load->class_code }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Indicator for More Items --}}
                @if($loads->count() > 6)
                    <p class="text-gray-600 text-sm mt-2">...{{ $loads->count() - 6 }} more</p>
                @endif

                {{-- Show All Button --}}
                <div class="mt-4 w-full flex justify-end">
                    <button onclick="openShowAllWindow()" 
                            class="w-[25%] bg-gray-700 text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition shadow-sm">
                        Show All
                    </button>
                </div>

                {{-- Confirmation Prompt --}}
                <form method="POST" action="" class="mt-6">
                    @csrf
                    <p class="text-gray-700 mb-4">Are you sure you want to proceed with this data?</p>
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition shadow-sm">
                        Confirm and Proceed
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- JavaScript to Open "Show All" Window --}}
    <script>
        function openShowAllWindow() {
            const url = "{{ route('admin.loads.imports') }}"; // Add your route here later
            window.open(url, "_blank", "width=900,height=500,scrollbars=yes,resizable=no");
        }
    </script>
</x-app-layout>
