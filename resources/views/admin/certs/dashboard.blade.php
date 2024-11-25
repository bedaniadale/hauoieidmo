<x-app-layout>
    <div class="w-full flex justify-center py-8">
        <div class="w-[95%] flex flex-col rounded-xl p-8 bg-white">
               <!-- Message Display -->
               @if(isset($msg) && $msg !== '')
                <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ $msg }}</span>
                </div>
                {{Session::forget('msg'); }}

                <script>
                    // Hide the success message after 5000 milliseconds (5 seconds)
                    setTimeout(function() {
                        document.getElementById('successMessage').style.display = 'none';
                    }, 10000);
                </script>
            @endif

            <!-- Sidebar Tabs and Content -->
            <div class="flex">
                <!-- Tabs -->
                <div class="w-1/4 border-r border-gray-200">
                    <ul class="flex flex-col space-y-4">
                        <li>
                            <button onclick="showContent('newCertificate')" class="tab-button w-full text-left py-2 px-4 text-red-900 font-bold bg-gray-200 rounded-md focus:outline-none" id="newCertificateTab">New Certificate</button>
                        </li>
                        <li>
                            <button onclick="showContent('issuedCertificates')" class="tab-button w-full text-left py-2 px-4 text-gray-400 rounded-md focus:outline-none" id="issuedCertificatesTab">Issued Certificates</button>
                        </li>
                    </ul>
                </div>

                <!-- Content Panels -->
                <div class="w-3/4 pl-8">
                    <!-- New Certificate Content -->
                    <div id="newCertificateContent" class="content-panel">
                        <h2 class="text-2xl font-bold mb-4">New Certificate</h2>
                        
                     
                        <form class="space-y-6" action="{{route('admin.certs.create')}}" method="POST" enctype="multipart/form-data">
                            @csrf 
                            @method('POST') 
                            <!-- Certificate Title -->
                            <div>
                                <label for="cert_title" class="block text-gray-700 font-semibold mb-2">Certificate Title</label>
                                <input type="text" id="cert_title" name="cert_title" placeholder="Enter certificate title"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <!-- Attachment Upload -->
                            <div>
                                <label for="attachment" class="block text-gray-700 font-semibold mb-2">Attachment</label>
                                <input type="file" id="attachment" name="attachment"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Date Issued -->
                            <div>
                                <label for="date_issued" class="block text-gray-700 font-semibold mb-2">Date Issued</label>
                                <input type="date" id="date_issued" name="date_issued"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Issued By -->

                            @if(Auth::user()->role === 'Dean')
                            <div>
                                <label for="issued_by" class="block text-gray-700 font-semibold mb-2">Issued By</label>
                                <input type="text" id="issued_by" name="issued_by" value="{{ Auth::user()->user->department->dept }}" readonly
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500 text-gray-400">
                            </div>
                        
                            @else 

                            <div>
                            <label for="issued_by" class="block font-semibold mb-2">Issued By</label>

                                <select name="issued_by" id="" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500">
                                    @foreach($depts as $dept)
                                        <option value="{{$dept->dept}}"> {{$dept->dept}}</option>
                                    @endforeach
                                </select>                                
                            </div>



                            @endif

                        

                            <!-- Duration -->
                            <div>
                                <label for="duration" class="block text-gray-700 font-semibold mb-2">Duration</label>
                                <input type="text" id="duration" name="duration" placeholder="e.g., 3 days"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Certificate Validity -->
                            <div>
                                <label for="cert_validity" class="block text-gray-700 font-semibold mb-2">Certificate Validity</label>
                                <input type="date" id="cert_validity" name="cert_validity"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Certificate Type -->
                            <div>
                                <label for="cert_type" class="block text-gray-700 font-semibold mb-2">Certificate Type</label>
                                <input type="text" id="cert_type" name="cert_type" placeholder="Enter certificate type"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
                                <input type="text" id="role" name="role" placeholder="Role of recipient"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" class="w-full bg-red-900 text-white py-3 rounded-lg font-semibold hover:bg-red-800 focus:ring focus:ring-blue-500 focus:outline-none">
                                    Create Certificate
                                </button>
                            </div>
                        </form>

                    </div>

                    <!-- Issued Certificates Content -->
                    <div id="issuedCertificatesContent" class="content-panel hidden">
                        <h2 class="text-2xl font-bold mb-4">Issued Certificates</h2>
                        @if(count($certs) > 0)
        <table class="w-full border border-red-900">
            <thead class="bg-red-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Certificate Title</th>
                    <th class="px-6 py-3 text-left font-semibold">Date Issued</th>
                    <th class="px-6 py-3 text-left font-semibold">Issued By</th>
                    <th class="px-6 py-3 text-left font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-red-900">
                @foreach($certs as $cert)
                    <tr>
                        <td class="px-6 py-4 ">{{ $cert->cert_title }}</td>
                        <td class="px-6 py-4 ">{{ \Carbon\Carbon::parse($cert->date_issued)->format('M d, Y') }}</td>
                        <td class="px-6 py-4 ">{{ $cert->issued_by }}</td>
                        <td class="px-6 py-4 ">
    <a href="{{ route('admin.certs.view', ['id' => $cert->id]) }}" class="text-red-900 hover:underline">View Details</a>
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">No certificates have been issued yet.</p>
    @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function showContent(tabName) {
            // Hide all content panels
            document.querySelectorAll('.content-panel').forEach(panel => panel.classList.add('hidden'));

            // Remove active styles from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('text-red-900', 'bg-gray-200', 'font-bold');
                button.classList.add('text-gray-400');
            });

            // Show the selected content panel
            document.getElementById(tabName + 'Content').classList.remove('hidden');

            // Add active styles to the clicked tab
            document.getElementById(tabName + 'Tab').classList.add('text-red-900', 'bg-gray-200', 'font-bold');
            document.getElementById(tabName + 'Tab').classList.remove('text-gray-400');
        }
    </script>
</x-app-layout>
