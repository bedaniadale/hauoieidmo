<x-app-layout>
    <div class="w-full flex justify-center py-8">
        <div class="w-[95%] flex flex-col p-8 bg-white shadow-lg relative rounded-lg">

            <!-- User Addition Section -->
            <div class="border border-gray-300 p-4 mb-8 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-red-900 mb-2">Add Users for Batch Issuing</h2>
                <div class="flex flex-col">
                    <!-- Search Bar -->
                    <div class="relative mb-4">
                        <input type="text" id="search" placeholder="Search user..." class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-red-300 focus:border-red-500 transition duration-200" />
                        <div id="search-results" class="mt-2 bg-white shadow-lg rounded-lg z-10 w-full hidden">
                            <div id="search-results-list" class="flex flex-col gap-1">
                                <!-- Search results will be displayed here -->
                            </div>
                        </div>
                    </div>

                    <!-- Queued Users -->
                    <h3 class="text-md font-semibold text-gray-700">Queued Users:</h3>
                    <form id="batch-issue-form" method="POST" action="{{ route('admin.certs.issue',['id'=> $data->id]) }}">
                        @csrf
                        <input type="hidden" name="queued_users" id="queued-users-input" />
                        
                        <table class="min-w-full border border-gray-300 mt-2">
                            <thead>
                                <tr class="bg-red-100">
                                    <th class="border border-gray-300 px-4 py-2 text-left text-gray-600">Employee ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left text-gray-600">Name</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left text-gray-600">Action</th>
                                </tr>
                            </thead>
                            <tbody id="queued-users">
                                <tr class="border-t border-gray-300">
                                    <td colspan="3" class="px-4 py-2 text-gray-600 text-center" id="no-users">No user added</td>
                                </tr>
                                <!-- Dynamically added user items will go here -->
                            </tbody>
                        </table>

                        <div class="mt-4">
                            <button type="submit" class="bg-red-900 hover:bg-red-800 text-white px-4 py-2 rounded-lg transition duration-200">Issue Certificate </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Certificate Details Section -->
            <h2 class="text-lg font-semibold text-red-900 mb-4">Certificate Details</h2>
            <div class="mb-8">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left text-gray-600">Field</th>
                            <th class="border border-gray-300 px-4 py-2 text-left text-gray-600">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><strong>Title:</strong></td>
                            <td class="border border-gray-300 px-4 py-2 font-medium">{{$data['cert_title']}}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><strong>Issued By:</strong></td>
                            <td class="border border-gray-300 px-4 py-2 font-medium">{{$data['issued_by']}}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><strong>Date Issued:</strong></td>
                            <td class="border border-gray-300 px-4 py-2 font-medium">{{$data['date_issued']}}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><strong>Validity:</strong></td>
                            <td class="border border-gray-300 px-4 py-2 font-medium">{{$data['cert_validity']}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    // Search functionality
    document.getElementById('search').addEventListener('input', function () {
        let searchQuery = this.value;
        fetchUsers(searchQuery);
    });

    function fetchUsers(query) {
        fetch(`{{ route('admin.users.search') }}?query=${encodeURIComponent(query)}`, {
            method: 'GET',
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            let resultsList = document.getElementById('search-results-list');
            let searchResults = document.getElementById('search-results');
            resultsList.innerHTML = ''; // Clear the current results

            if (data.length > 0) {
                data.forEach(user => {
                    let profilePicture = user.profile_picture
                        ? `{{ asset('storage/profile_pictures/') }}/${user.profile_picture}`
                        : `{{ asset('images/blankdp.jpg') }}`;

                    let row = `
                        <div class="flex items-center justify-between border p-2 rounded-md shadow-sm bg-gray-50 hover:bg-gray-100 transition duration-200 cursor-pointer" onclick="addToQueue(${user.emp_id}, '${user.emp_lname}', '${user.emp_fname}', '${user.emp_mname}', '${profilePicture}')">
                            <div class="flex items-center gap-2">
                                <img src="${profilePicture}" class="w-[35px] h-[35px] rounded-full" alt="user_image" />
                                <h1 class="text-sm font-medium text-gray-800">${user.emp_lname}, ${user.emp_fname} ${user.emp_mname}</h1>
                            </div>
                            <button class="bg-red-900 hover:bg-red-800 text-white px-2 py-1 rounded-lg transition duration-200">Add</button>
                        </div>
                    `;
                    resultsList.innerHTML += row;
                });
                searchResults.classList.remove('hidden'); // Show the results
            } else {
                searchResults.classList.add('hidden'); // Hide if no results
            }
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
    }

    function addToQueue(empId, lastName, firstName, middleName, profilePicture) {
        // Check if the user is already in the queued list
        const queuedList = document.getElementById('queued-users');
        const existingUser = Array.from(queuedList.querySelectorAll('tr')).some(row => {
            return row.cells[0].innerText.trim() === empId.toString(); // Check by Employee ID
        });

        if (existingUser) {
            alert('This user is already added to the queue.');
            return; // Exit if the user is already queued
        }

        // Add the user to the queued users list
        let noUsersMessage = document.getElementById('no-users');
        noUsersMessage.style.display = 'none'; // Hide the "No user added" message

        let queuedUser = `
            <tr class="border-t border-gray-300">
                <td class="border border-gray-300 px-4 py-2">${empId}</td>
                <td class="border border-gray-300 px-4 py-2"><div class="flex items-center gap-2"><img src="${profilePicture}" class="w-[30px] h-[30px] rounded-full" alt="user_image" /><span>${lastName}, ${firstName} ${middleName}</span></div></td>
                <td class="border border-gray-300 px-4 py-2">
                    <button onclick="removeFromQueue(this)" class="text-red-600 hover:text-red-500 transition duration-200">Remove</button>
                </td>
            </tr>
        `;
        queuedList.innerHTML += queuedUser;

        // Optionally, clear search results after adding
        document.getElementById('search-results-list').innerHTML = ''; // Clear search results
        document.getElementById('search-results').classList.add('hidden'); // Hide the results after adding
    }

    function removeFromQueue(button) {
        // Remove the user from the queued users list
        button.closest('tr').remove();

        // Check if there are any queued users left
        let queuedList = document.getElementById('queued-users');
        
        // If no rows other than the 'no users' message exist
        if (queuedList.children.length === 1) { 
            document.getElementById('no-users').style.display = 'table-row'; // Show the "No user added" message
        }
    }

    // Submit the form and gather the user IDs before submission
    document.getElementById('batch-issue-form').addEventListener('submit', function (event) {
        const queuedList = document.getElementById('queued-users');
        const userIds = Array.from(queuedList.querySelectorAll('tr:not(:first-child)'))
            .map(row => row.cells[0].innerText.trim()); // Get Employee IDs

        document.getElementById('queued-users-input').value = JSON.stringify(userIds); // Serialize and set the input value
    });
</script>
