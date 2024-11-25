<x-app-layout>
<div class="w-full flex justify-center py-8">
    <div class="w-[95%] flex flex-col items-start p-8 bg-white rounded-xl">
    
    <a href="{{route('admin.loads.db')}}" class="flex gap-1 items-center justify-center bg-red-900 hover:bg-red-700 px-6 py-1 text-white rounded-xl">
        <img src="{{asset('images/icons/back.png')}}" class="w-[20px] h-[20px]" alt="">
        <span>Return to Tools</span>
    </a>

    <div class="flex flex-col gap-0 leading-tight mb-2">
        <h1 class="text-gray-600 font-bold text-[2rem]">Show Loads by Subject</h1>
        <span class="text-gray-400 text-sm">Teaching Loads</span>
    </div>

    <!-- Search Bar -->
    <input type="text" id="search" placeholder="Search subjects..." class="w-full border border-gray-300 p-2 rounded-md mb-4">

    <span class="text-gray-500 mb-2"> List of Subjects</span>

    <form method="POST" action="{{ route('admin.subjects.destroy') }}" class="w-full bg-white rounded-lg">
    <div class="mb-4 w-full bg-red-600 bg-opacity-100 backdrop-blur-lg px-4 py-1 rounded-xl flex items-center gap-4 justify-center" id="sel">
        <button onclick="resetSelect()" type="button" class="text-white hover:text-gray-100 underline">Cancel</button>
        <span id="selectedCount" class="text-white font-extrabold">Selected Subject/s: 0</span>
        <button type="button" class="ml-auto flex items-center justify-center text-white px-4 py-1 rounded-md hover:bg-red-800" onclick="confirmDelete(this)">
            <img src="{{asset('images/icons/delete.png')}}" alt="" class="w-[20px] h-[20px]">
            <span>Delete</span>
        </button>
    </div>

    @csrf
    @method('DELETE') 

    <table class="w-full bg-white border border-gray-100 h-[100px] overflow-y-auto">
        <thead>
            <tr class="w-full bg-red-900 text-gray-800 text-white">
        
                <th class="py-2 px-4 text-left">Subject Code</th>
                <th class="py-2 px-4 text-left">Subject Name</th>
                <th class="py-2 px-4 text-left">Units</th>
                <th class="py-2 px-4 text-left"></th>
            </tr>
        </thead>
        <tbody id="subject-list">
            @foreach($subjects as $option)
                <tr class="border-b text-gray-500">
                  
                    <td class="py-2 px-4">{{ $option->subj_code }}</td>
                    <td class="py-2 px-4">{{ $option->subj_title }}</td>
                    <td class="py-2 px-4">{{ $option->units }}</td>
                    <td class="py-2 px-4">
                        <a href="{{route('admin.lbs.view', ['id'=> $option->subj_id])}}" class=" flex items-center justify-center p-1  bg-red-900 hover:bg-red-800">
                            <img src="{{asset('images/icons/right.png')}}" alt="" class="w-[20px] h-[20px]">
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{$subjects->links()}}


    </form>
</div>
</div>
</x-app-layout>

<style>
    #sel { 
        display: none; 
    }
</style>

<script>
    let checkedItems = new Set();

    document.getElementById('search').addEventListener('input', function() {
        let searchQuery = this.value;
        fetchSubjects(searchQuery);
    });

    function fetchSubjects(query) {
        fetch(`{{ route('admin.subjects.search2') }}?query=${query}`)
            .then(response => response.json())
            .then(data => {
                let tbody = document.getElementById('subject-list');
                tbody.innerHTML = ''; // Clear the current list
                data.forEach(subject => {
                    const isChecked = checkedItems.has(subject.subj_id);
                    let route = `loads/${subject.subj_id}`
                    let row = `
                        <tr class="border-b text-gray-500">
                        
                            <td class="py-2 px-4">${subject.subj_code}</td>
                            <td class="py-2 px-4">${subject.subj_title}</td>
                            <td class="py-2 px-4">${subject.units}</td>

                            <td class="py-2 px-4">
                        <a href="${route}" class=" flex items-center justify-center p-1  bg-red-900 hover:bg-red-800">
                            <img src="{{asset('images/icons/right.png')}}" alt="" class="w-[20px] h-[20px]">
                        </a>
                    </td>

                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            });
    }

    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const selectedCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checkedItems.add(checkbox.value);
            } else {
                checkedItems.delete(checkbox.value);
            }
        });

        if (selectedCount > 0) {
            document.getElementById('sel').style.display = 'flex';
            document.getElementById('selectedCount').textContent = `Selected Subject/s: ${selectedCount}`;
        } else {
            document.getElementById('sel').style.display = 'none';
        }
    }

    function resetSelect() {
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => checkbox.checked = false);
        checkedItems.clear();
        updateSelectedCount();
    }

    function confirmDelete(button) {
        if (confirm('Are you sure you want to delete selected subject/s?')) {
            button.closest('form').submit();
        }
    }
</script>
