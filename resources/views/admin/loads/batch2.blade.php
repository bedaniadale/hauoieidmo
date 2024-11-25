<x-app-layout>
    <div class="w-full flex justify-center py-8">
        <div class="w-[95%] flex flex-col bg-white rounded-lg p-8 shadow-lg">
            <!-- Header -->
            <div class="flex flex-col mb-4">
                <h1 class="text-[1.5rem] font-bold">Batch Load of Subjects</h1>
                <span class="text-gray-500">Load multiple subjects/teaching loads to users</span>
            </div>

            <!-- Subject Details -->
            <div class="w-full grid grid-cols-[25%_75%] border border-gray">
                <div class="p-2 border-r border-gray flex items-center justify-center">
                    <h1 class="text-gray-500 font-semibold text-sm">SUBJECT CODE</h1>
                </div>
                <div class="p-2">
                    <h1 class="text-gray-500 text-sm">{{$subj->subj_code}}</h1>
                </div>
            </div>
            <div class="w-full grid grid-cols-[25%_75%] border border-gray">
                <div class="p-2 border-r border-gray flex items-center justify-center">
                    <h1 class="text-gray-500 font-semibold text-sm">SUBJECT</h1>
                </div>
                <div class="p-2">
                    <h1 class="text-gray-500 text-sm">{{$subj->subj_title}}</h1>
                </div>
            </div>
            <div class="w-full grid grid-cols-[25%_75%] border border-gray mb-4">
                <div class="p-2 border-r border-gray flex items-center justify-center">
                    <h1 class="text-gray-500 font-semibold text-sm">UNITS</h1>
                </div>
                <div class="p-2">
                    <h1 class="text-gray-500 text-sm">{{$subj->units}}.00</h1>
                </div>
            </div>

            <!-- User Addition Section -->
            <div class="border border-gray-300 p-4 mb-8 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold text-red-900 mb-2">School Year & Semester</h2>
                <div class="relative mb-4">

                    <!-- Queued Users -->
                    <form id="batch-issue-form" method="POST" action="{{ route('admin.queue.upload') }}">
                        @csrf
                        <input type="hidden" name="subj_code" value="{{$subj->subj_code}}">
                        <input type="hidden" name="queued_users" id="queued-users-input" />

                        <!-- School Year and Semester Form -->
                        <div class="w-full grid grid-cols-[25%_75%] border border-gray mb-4">
                            <div class="p-2 border-r border-gray flex items-center justify-center">
                                <h1 class="text-gray-500 font-semibold text-sm">SCHOOL YEAR</h1>
                            </div>
                            <div class="p-2 flex gap-2">
                                <input type="text" name="sy_start" placeholder="XXXX" class="w-1/2 border border-gray-300 p-2 rounded-lg text-center" />
                                <span class="text-gray-500 font-semibold">-</span>
                                <input type="text" name="sy_end" placeholder="XXXX" class="w-1/2 border border-gray-300 p-2 rounded-lg text-center" />
                            </div>
                        </div>
                        <div class="w-full grid grid-cols-[25%_75%] border border-gray mb-4">
                            <div class="p-2 border-r border-gray flex items-center justify-center">
                                <h1 class="text-gray-500 font-semibold text-sm">SEMESTER</h1>
                            </div>
                            <div class="p-2">
                                <select name="sem" class="w-full border border-gray-300 p-2 rounded-lg">
                                    @foreach($semesters as $item)
                                    <option value="{{$item->item}}">{{$item->item}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="w-full opacity-60">
                        <h2 class="text-lg font-semibold text-red-900 mb-2">Add Users for Batch Loading Subjects</h2>

                        <input type="text" id="search" placeholder="Search user..." class="w-full border border-gray-300 p-2 rounded-lg focus:ring focus:ring-red-300 focus:border-red-500 transition duration-200" />
                        <div id="search-results" class="mt-2 bg-white shadow-lg rounded-lg z-10 w-full hidden">
                            <div id="search-results-list" class="flex flex-col gap-1">
                                <!-- Search results will be displayed here -->
                            </div>
                        </div>

                        <h3 class="text-md font-semibold text-gray-700">Loaded Users:</h3>

                        <table class="min-w-full border border-gray-300 mt-2">
                            <thead>
                                <tr class="bg-red-100">
                                    <th class="border border-gray-300 px-4 py-2 text-left text-gray-600">Employee ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left text-gray-600">Class Code</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left text-gray-600">Name</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left text-gray-600">Action</th>
                                </tr>
                            </thead>
                            <tbody id="queued-users">
                                <tr class="border-t border-gray-300">
                                    <td colspan="4" class="px-4 py-2 text-gray-600 text-center" id="no-users">No user added</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4">
                            <button type="submit" class="bg-red-900 hover:bg-red-800 text-white px-4 py-2 rounded-lg transition duration-200">Batch Upload</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reminder Message -->
            <div class="w-full flex flex-col items-end my-2">
                <span class="text-gray-500 text-sm"><strong>Reminder:</strong> Please verify that the selected users are final. Note that if an employee already has the subject in their teaching load, the system will automatically ignore the request to add a new one.</span>
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
    if (!query) {
        document.getElementById('search-results').classList.add('hidden'); // Hide if input is empty
        return; // Exit if the query is empty
    }
    
    fetch(`{{ route('admin.pendings.search2') }}?query=${encodeURIComponent(query)}`, {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        let resultsList = document.getElementById('search-results-list');
        let searchResults = document.getElementById('search-results');
        resultsList.innerHTML = ''; // Clear the current results

        if (data.length > 0) {
            data.forEach(user => {
                let row = `
                    <div class="flex items-center justify-between border p-2 rounded-md shadow-sm bg-gray-50 hover:bg-gray-100 transition duration-200 cursor-pointer" onclick="addToQueue(${user.emp_id}, '${user.emp_lname}', '${user.emp_fname}', '${user.emp_mname}')">
                        <h1 class="text-sm font-medium text-gray-800">${user.emp_lname}, ${user.emp_fname} ${user.emp_mname}</h1>
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
        document.getElementById('search-results').classList.add('hidden'); // Hide results on error
    });
}

function addToQueue(empId, lastName, firstName, middleName) {
    console.log("Adding to queue:", empId, lastName, firstName, middleName); // Debugging statement

    // Add the user to the queued users list
    let noUsersMessage = document.getElementById('no-users');
    noUsersMessage.style.display = 'none'; // Hide the "No user added" message

    let queuedUser = `
        <tr class="border-t border-gray-300">
            <td class="border border-gray-300 px-4 py-2">${empId}</td>
            <td class="border border-gray-300 px-4 py-2">
                <input type="text" placeholder="Enter class code" class="border border-gray-300 p-1 rounded-lg w-full" required/>
            </td>
            <td class="border border-gray-300 px-4 py-2">${lastName}, ${firstName} ${middleName}</td>
            <td class="border border-gray-300 px-4 py-2">
                <button onclick="removeFromQueue(this)" class="text-red-600 hover:text-red-500 transition duration-200">Remove</button>
            </td>
        </tr>
    `;
    document.getElementById('queued-users').innerHTML += queuedUser;

    // Clear search results after adding
    document.getElementById('search').value = '';
    document.getElementById('search-results-list').innerHTML = ''; // Clear search results
    document.getElementById('search-results').classList.add('hidden'); // Hide the results after adding

    console.log("Search results hidden"); // Debugging statement
}


    function removeFromQueue(button) {
        // Remove user from the queued list
        button.closest('tr').remove();
        let queuedUsers = document.getElementById('queued-users').rows;
        if (queuedUsers.length <= 1) {
            document.getElementById('no-users').style.display = ''; // Show "No user added" message
        }
    }

    // Handle form submission
    document.getElementById('batch-issue-form').addEventListener('submit', function (event) {
        const queuedList = document.getElementById('queued-users');
        const userRows = Array.from(queuedList.querySelectorAll('tr:not(:first-child)'));

        if (userRows.length === 0) {
            alert("Please add at least one user to the queue before submitting.");
            event.preventDefault(); // Prevent form submission
            return;
        }

        const userData = userRows.map(row => {
            const empId = row.cells[0].innerText.trim(); // Get Employee ID
            const classCode = row.cells[1].querySelector('input').value.trim(); // Get class code
            return `${classCode}-${empId}`; // Format as "classCode - empId"
        });

        document.getElementById('queued-users-input').value = JSON.stringify(userData); // Serialize and set the input value
    });
</script>
