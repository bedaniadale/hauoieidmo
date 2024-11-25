<x-app-layout>
    <div class="w-full flex items-center justify-center py-12 bg-gray-50">
        <div class="w-[90%] lg:w-[60%] bg-white shadow-xl rounded-lg p-8">

            <!-- Logo Section -->
            <div class="w-full flex justify-center my-4">
                <img src="{{asset('images/logo-circle.png')}}" class="w-[120px] h-[120px]" alt="Logo">
            </div>

            <h1 class="text-3xl font-bold text-center text-gray-900 mb-8">Update Subjects via File Upload</h1>

            @if($imported == false)
                <!-- File Upload Form Start -->
                <form action="{{ route('admin.subjects.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('POST')

                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Import Subjects</h2>

                    <!-- Custom File Upload -->
                    <div class="flex flex-col space-y-4">
                        <label for="file" class="text-lg font-medium text-gray-700">Choose a file</label>

                        <!-- File Input Section -->
                        <div class="flex justify-between items-center px-4 py-3 bg-gray-100 border border-gray-300 rounded-md cursor-pointer hover:shadow-md transition-shadow relative">
                            <input type="file" name="file" id="file" class="absolute inset-0 opacity-0 cursor-pointer" onchange="updateFileName()" required>
                            <span id="file-name" class="text-sm text-gray-700">No file selected</span>
                            <span class="text-red-900 font-semibold">Choose File</span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full mt-4">
                            <div class="w-full bg-gray-200 h-2 rounded-full">
                                <div id="progress-bar" class="bg-red-900 h-2 rounded-full" style="width: 0;"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-3 bg-red-900 text-white font-medium rounded-md hover:bg-red-800 transition-colors shadow-md transform hover:scale-105">
                            Upload File
                        </button>
                    </div>
                </form>
                <!-- File Upload Form End -->

            @else
                <!-- Summary Section Starts -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-lg border border-gray-300 mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Subject Summary</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between text-lg text-gray-700">
                            <span><strong>Total Subjects:</strong></span>
                            <span class="font-semibold text-red-900">{{ $subjects->count() }}</span>
                        </div>
                        <div class="flex justify-between text-lg text-gray-700">
                            <span><strong>Total Units:</strong></span>
                            <span class="font-semibold text-red-900">{{ $subjects->sum('units') }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center space-x-4">
    <!-- View Details Button -->
    <button type="button" onclick="openPopup()" class="py-2 px-6 bg-red-900 text-white font-medium rounded-md hover:bg-red-800 transition-colors shadow-md transform hover:scale-105">
        View Details
    </button>

    <!-- Load Subjects Form -->
    <form action="{{ route('admin.subjects.save') }}" method="POST">
        @csrf
        <button type="submit" class="py-2 px-6 bg-gray-900 text-white font-medium rounded-md hover:bg-gray-800 transition-colors shadow-md transform hover:scale-105">
            Load Subjects
        </button>
    </form>
</div>

            @endif

        </div>
    </div>

    <script>
        // Update file name display when file is selected
        function updateFileName() {
            const fileInput = document.getElementById('file');
            const fileNameDisplay = document.getElementById('file-name');
            const file = fileInput.files[0];
            if (file) {
                fileNameDisplay.textContent = file.name; // Display the selected file name
            } else {
                fileNameDisplay.textContent = "No file selected";
            }
        }

        // Handle file upload progress (simulate for now)
        const fileInput = document.getElementById('file');
        const progressBar = document.getElementById('progress-bar');

        fileInput.addEventListener('change', function() {
            // Simulate the progress bar update for the file upload (this is where you would hook into your backend upload)
            let progress = 0;
            const interval = setInterval(function() {
                if (progress < 100) {
                    progress += 10;
                    progressBar.style.width = progress + '%';
                } else {
                    clearInterval(interval);
                }
            }, 300); // Update every 300ms to simulate progress
        });

        // Open the popup window for subject details
        function openPopup() {
            window.open("{{ route('admin.subjects.popup') }}", "popupWindow", "width=900,height=400,scrollbars=yes,resizable=no");
        }

      
    </script>

</x-app-layout>
