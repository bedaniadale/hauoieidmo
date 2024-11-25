<x-app-layout>
    <div class="w-full flex justify-center py-8">
        <div class="w-[95%] flex flex-col justify-start items-start rounded-xl p-8 bg-white shadow-lg">

        <a href="{{route('admin.lbs')}}" class="flex gap-1 items-center justify-center bg-red-900 hover:bg-red-700 px-6 py-1 text-white rounded-xl">
        <img src="{{asset('images/icons/back.png')}}" class="w-[20px] h-[20px]" alt="">
        <span>Return to Subjects</span>
    </a>

            
            <!-- Subject Details Section -->
            <div class="mb-8 w-full">
                <h2 class="text-2xl font-bold text-red-900 mb-4">Subject Details</h2>
                <div class="bg-gray-100 p-6 rounded-lg shadow-inner">
                    <p class="text-gray-700"><strong>Subject ID:</strong> {{ $subj->subj_id }}</p>
                    <p class="text-gray-700"><strong>Subject Code:</strong> {{ $subj->subj_code }}</p>
                    <p class="text-gray-700"><strong>Subject:</strong> {{ $subj->subj_title }}</p>
                    <p class="text-gray-700"><strong>Units:</strong> {{ $subj->units }}</p>
                </div>
            </div>

            <!-- Loads List Section -->
            <div class="mb-8 w-full">
                <h2 class="text-2xl font-bold text-red-900 mb-4">Teaching Loads</h2>
                <div class="overflow-x-auto flex flex-col">
                    @if($loads->count() > 0) 
                    <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow-lg overflow-hidden">
    <thead class="bg-red-900 text-white">
        <tr class="grid grid-cols-[20%_80%]">
            <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Employee ID</th>
            <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Full Name</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @foreach($loads as $load)
        <tr class="grid grid-cols-[20%_80%] text-gray-600 hover:bg-gray-100 transition duration-300">
            <td class="px-6 py-4 whitespace-nowrap text-md">{{ $load->user->emp_id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-md">{{ $load->user->emp_lname }}, {{ $load->user->emp_fname }} {{ $load->user->emp_mname }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


                    @else 
                        <div class="w-full">
                            <span class="text-gray-400 text-[0.8rem]">No user loaded into this subject.</span>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
