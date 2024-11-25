<x-app-layout>
    <div class="flex justify-center py-8">
        <div class="w-[95%] max-w-4xl bg-white rounded-lg p-8 shadow-lg">
            <h1 class="text-3xl font-extrabold text-gray-800 text-center">Edit User Profile</h1>

            <!-- Breadcrumb -->
            <div class="flex items-center justify-center gap-2 mt-4">
                <img src="{{ asset('images/icons/users_maroon.png') }}" class="w-6 h-6" alt="Users Icon">
                <a href="{{ route('admin.users') }}" class="text-red-900 hover:text-red-700 font-semibold">Users</a>
                <span class="text-lg">&gt;</span>
                <span class="font-semibold">{{ $data->emp_id }}</span>
            </div>

            <hr class="opacity-90 my-4">

            <!-- Form -->
            <form method="POST" action="" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Employee ID -->
                <div>
                    <label for="emp_id" class="block text-sm font-semibold text-gray-700">Employee ID</label>
                    <input type="text" id="emp_id" name="emp_id" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-red-900 focus:border-red-900" value="{{ $data->emp_id }}" readonly>
                </div>

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-semibold text-gray-700">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-red-900 focus:border-red-900" value="{{ $data->first_name }}" required>
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-semibold text-gray-700">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-red-900 focus:border-red-900" value="{{ $data->last_name }}" required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <input type="email" id="email" name="email" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-red-900 focus:border-red-900" value="{{ $data->email }}" required>
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-semibold text-gray-700">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-red-900 focus:border-red-900" value="{{ $data->contact_number }}" required>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-semibold text-gray-700">Address</label>
                    <textarea id="address" name="address" rows="3" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-red-900 focus:border-red-900">{{ $data->address }}</textarea>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-red-900 focus:border-red-900">
                        <option value="active" {{ $data->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $data->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 text-white bg-red-900 rounded-md hover:bg-red-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
