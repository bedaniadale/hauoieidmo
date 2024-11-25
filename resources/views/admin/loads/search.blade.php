@php
$count = 1; 
@endphp

<x-app-layout>
<div class="w-full flex justify-center py-8">
    <div class="w-[95%] flex flex-col rounded-xl p-8 bg-white">
            <section class='search-header'>
                <form action="{{ route('admin.loads.user.search') }}" method="GET" class="flex flex-col items-center">
                    @csrf
                    @method('GET')
                    <h1 class="text-2xl font-bold text-red-900">View User's Load</h1>
                    <span class="text-gray-600 text-sm mt-2 text-center">
                        Kindly provide relevant keywords such as names to assist in locating the user. Accurate keywords will help streamline the search process.
                    </span>
                    <div class="formrow mt-4 flex space-x-2">
                        <input id="search" type="text" name="id" placeholder="Enter Employee ID..." class="border border-gray-300 rounded-lg px-4 py-2">
                        <button type="submit" class="bg-red-900 text-white rounded-lg px-4 py-2 hover:bg-red-800">Load User</button>
                    </div>

                    @if(isset($errormsg))
                        <span class="mt-1 text-red-500">{{ $errormsg }}</span>
                    @endif
                </form> 
            </section>

            @if(!isset($userinfo)) 
                <hr class="my-4 border-gray-300"> 
                <div class="w-full flex flex-col">
                    <h1 class="text-xl font-bold text-red-900">Your Recent Activity</h1>
                    <span class="text-gray-400 text-sm italic">Track the most recent loads you've shared with others</span>

                    <div class="flex flex-col w-full border border-gray-400 mt-2 rounded-lg overflow-hidden">
                        <div class="w-full bg-gray-500 grid grid-cols-[10%_30%_40%_20%] text-white p-2">
                            <h1>ID</h1>
                            <h1>FULL NAME</h1>
                            <h1>SUBJECT</h1>
                            <h1>DATE</h1>
                        </div>

                        @if($loads->count() == 0)
                            <div class="w-full flex items-center justify-center text-sm text-gray-400 pt-4 pb-12">
                                <span class="italic py-8">No user data.</span> 
                            </div>
                        @else
                            @foreach($loads as $load) 
                                <div class="w-full grid grid-cols-[10%_30%_40%_20%] text-gray-600 p-2 border-b border-gray-200">
                                    <h1>{{ $load->emp_id }}</h1>
                                    <h1>{{ $load->user->emp_lname . ', ' . $load->user->emp_fname . ' ' . $load->user->emp_mname }}</h1>
                                    <h1>{{ $load->subject->subj_code . ' - ' . $load->subject->subj_title }}</h1>
                                    <h1>{{ $load->created_at }}</h1>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

            @if(isset($msg))
            <div class="w-full flex items-center justify-between bg-green-600 text-white rounded-lg px-4 py-2 shadow-md my-2">
    <div class="flex items-center space-x-2">
        <svg class="w-6 h-6 text-green-300" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 0a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm1 15.293l5-5-1.414-1.414L11 12.586l-2.586-2.586L7 10l4 4 1 1.293z" />
        </svg>
        <h1 class="font-bold text-lg">{{ $msg }}</h1>
    </div>
    <button onclick="this.parentElement.remove();" class="text-white hover:text-gray-200 transition duration-200">
        &times; <!-- Close button -->
    </button>
</div>

            @endif

            @if(isset($userinfo)) 
                <section class="userinfo mb-4">
                    <h1 class="text-2xl font-bold text-red-900">{{ $userinfo->emp_id }}</h1>
                    <h1 class='name text-xl'>{{ $userinfo->emp_lname . ', ' . $userinfo->emp_fname . ' ' . $userinfo->emp_mname }}</h1>
                    <span class="text-gray-600">{{ $userinfo->email_address_1 }}</span>
                </section>

                <div class="table-section mb-4">
    <div class="table main-dep w-full border border-gray-300 rounded-lg overflow-hidden shadow-md">
        @if($loads->count() == 0) 
            <div class="w-full flex items-center justify-center text-sm text-gray-400 pt-4 pb-12">
                <span class="italic py-8">No user data.</span> 
            </div>
        @else
            <div class="px-2 grid grid-cols-[15%_30%_10%_10%_15%_10%_5%] bg-red-900 text-white">
                <div class="py-2 font-bold ">SUBJ CODE</div>
                <div class="py-2 font-bold ">SUBJECT</div>
                <div class="py-2 font-bold ">CLASS</div>
                <div class="py-2 font-bold ">SY</div>
                <div class="py-2 font-bold ">SEMESTER</div>
                <div class="py-2 font-bold ">UNITS</div>
                <div class="py-2 font-bold ">ACTION</div>
            </div>

            @foreach($loads as $item) 
                <div class="px-2 {{ $count % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} grid grid-cols-[15%_30%_10%_10%_15%_10%_5%] py-4 border-b border-gray-300"> 
                    <div class="">{{ $item->subject->subj_code }}</div> 
                    <div class="">{{ $item->subject->subj_title }}</div>
                    <div class="">{{ $item->class_code }}</div> 
                    <div class="">{{ $item->sy }}</div> 
                    <div class="">{{ $item->semester }}</div> 
                    <div class="">{{ $item->subject->units }}.00</div> 
                    <div class=""> 
                        <form id="edit-dependent-form" action="{{ route('admin.loads.delete', ['id' => $item->id]) }}" method="POST"> 
                            @csrf
                            @method('DELETE') 
                            <input type="text" name="emp_id" value="{{ $userinfo->emp_id }}" hidden/> 
                            <button type="button" onclick = "confirmDelete(this)" class="bg-red-900 text-white rounded-lg px-2 py-1 hover:bg-red-800 transition duration-200">Delete</button>  
                        </form> 
                    </div>
                </div>
                @php $count++; @endphp 
            @endforeach
        @endif
    </div>
</div>


            @endif
        </div>
    </div>
</x-app-layout>

<script>
    function confirmDelete(button) { 
        if(confirm('Are you sure you want to delete this load?')) { 
            const form = button.closest('form'); 
            form.submit(); 
        }
    }


    setTimeout(function() {
        document.querySelector('.dep-msg').innerHTML = '';
    }, 5000); // Hide after 5 seconds

    // For confirmation 
    function confirmClearDependencies() {
        if (confirm('Are you sure you want to clear the dependencies?')) {
            document.getElementById('clear-dependencies-form').submit();
        }
    }

    function deleteDependency(button)  {
        const form = button.closest('form');
        if(confirm('Are you sure you want to cancel this request?')) { 
            form.submit()
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const searchResults = document.querySelector('.search-results');
        let debounceTimeout;

        function debounce(func, delay) {
            return function() {
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(func, delay);
            };
        }

        function performSearch() {
            const query = searchInput.value;

            if (query === '') {
                searchResults.innerHTML = ''; // Clear results if the input is empty
                return;
            }

            fetch(`{{ route('admin.pendings.search2') }}?query=${encodeURIComponent(query)}`, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = ''; // Clear previous results

                if (data.length > 0) {
                    data.forEach(post => {
                        const resultItem = document.createElement('div');

                        resultItem.innerHTML = `
                            <button type="button" class="sr-item" style="background-color: beige; color: black;">
                                <div class="details">
                                    <h1>${post.emp_lname}, ${post.emp_fname} ${post.emp_mname}</h1>
                                    <h3>${post.emp_id}</h3>
                                    <span>${post.email_address_1}</span>
                                </div>
                            </button>
                        `;
                        searchResults.appendChild(resultItem);

                        // Add the event listener to the dynamically created button
                        const button = resultItem.querySelector('.sr-item');
                        button.addEventListener('click', () => {
                            const h3Element = button.querySelector('.details h3');
                            const h3Content = h3Element.innerHTML;
                            searchInput.value = h3Content; // Set the input value to the h3 content
                            searchResults.innerHTML = '';
                        });
                    });
                } else {
                    searchResults.innerHTML = '<div style="padding: 0.5rem 1rem"><span>No results found</span></div>';
                }
            })
            .catch(error => console.error('Error fetching search results:', error));
        }

        searchInput.addEventListener('input', debounce(performSearch, 300)); // Debounce for input
    });
</script>

<style>
    .table {
        width: 100%;
        border-collapse: collapse;
    }



    .tbl-row:nth-child(even) {
        background-color: #f7fafc; /* Light gray for even rows */
    }

    .tbl-row:hover {
        background-color: #edf2f7; /* Light hover effect */
    }
</style>
