@can('user')
{{__("FORBIDDEN")}}
@endcan
@cannot('user')
    <x-app-layout>
        @if(session()->has('success'))
            <div>
                <p>{{session('success')}}</p>
            </div>
        @endif
        @if(session('alert'))
        @if(session('alert-type') == 'success')
            <script>
                alert("{{ session('alert') }}");
            </script>
        @endif
    @endif
        <div class=" mx-auto add-usercss flex justify-center">
            <div class=" add-usercss2 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-2">Enter new Employee Details</h3>
                <div class="w-full lg:w-3/4 xl:w-1/2">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <table class="table-add-usercss">
                        <tr>
                            <th>Profile Image:</th>
                            <td>
                                @if ($user && $user->image)
                                    <img src="{{ asset('storage/images' . $user->image) }}" alt="Profile Picture" width="200">
                                @else
                                    <p class="mt-2">Upload profile picture</p>
                                    <input type="file" name="image">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th><label for="first_name">First Name:</label></th>
                            <th><input class="w-full text-gray-800 bg-gray-100" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required></th>
                        </tr>
                        <tr>
                            <th><label for="middle_name">Middle Name:</label></th>
                            <th><input class="w-full text-gray-800 bg-gray-100" type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}"></th>
                        </tr>
                        <tr>
                            <th><label for="last_name">Last Name:</label></th>
                            <th><input class="w-full text-gray-800 bg-gray-100" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required></th>
                        </tr>
                        <tr>
                            <th><label for="number">Number:</label></th>
                            <th><input class="w-full text-gray-800 bg-gray-100" type="text" id="number" name="number" value="{{ old('number') }}" required></th>
                        </tr>
                        <tr>
                            <th><label for="address">Address:</label></th>
                            <th><input class="w-full text-gray-800 bg-gray-100" type="text" id="address" name="address" value="{{ old('address') }}" required></th>
                        </tr>
                        <tr>
                            <th><label for="email">Email:</label></th>
                            <th><input class="w-full text-gray-800 bg-gray-100" type="email" id="email" name="email" value="{{ old('email') }}" required></th>
                        </tr>
                        <tr>
                            <th><label for="password">Password:</label></th>
                            <th><input class="w-full text-gray-800 bg-gray-100" type="password" id="password" name="password" required></th>
                        </tr>
                        <tr>
                            <th><label for="position">Position:</label></th>
                            <th><input class="w-full text-gray-800 bg-gray-100" type="text" id="position" name="position" value="{{ old('position') }}" required></th>
                        </tr>
                        <tr>
                            <th><label for="user_role">User Role:</label></th>
                            <th>
                                <select id="user_role" name="user_role" class="w-full text-gray-800 bg-gray-100" required>
                                    <option value="">Select User Role</option>
                                    <option value="admin" {{ old('user_role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="superadmin" {{ old('user_role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                    <option value="user" {{ old('user_role') == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </th>
                        </tr>
                    </table>
                    <button type="submit">Create User</button>
                </form>

                </div>
            </div>
        </div>
    </x-app-layout>
@endcannot