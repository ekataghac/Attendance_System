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
        <div class=" add-usercss2 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 ">
        <h3 class="font-semibold text-lg mb-2">Edit Employee Detail</h3>
            <div class="w-full lg:w-3/4 xl:w-1/2">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table-add-usercss">
                    <tr>
                        <th><label for="image">Profile Image:</label></th>
                        <th><input type="file" id="image" name="image"></th>
                        @if ($user->image)
                            <p>Current image:</p>
                            <img src="{{ asset('storage/images/' . $user->image) }}" alt="Profile picture" style="max-width: 200px">
                        @endif
                    </tr>
                    <tr>
                        <th><label for="first_name">First Name:</label></th>
                        <th> <input class="w-full text-gray-800 text-center bg-gray-100" type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" required></th>
                   </tr>
                    <tr>
                        <th><label for="middle_name">Middle Name:</label></th>
                        <th> <input class="w-full text-gray-800 text-center bg-gray-100" type="text" id="middle_name" name="middle_name" value="{{ $user->middle_name }}"></th>
                    </tr>
                    <tr>
                        <th><label for="last_name">Last Name:</label></th>
                        <th><input class="w-full text-gray-800 text-center bg-gray-100" type="text" id="last_name" name="last_name" value="{{ $user->last_name }}" required></th>
                    </tr>
                    <tr>
                        <th> <label for="number">Number:</label></th>
                        <th><input class="w-full text-gray-800 text-center bg-gray-100" type="text" id="number" name="number" value="{{ $user->number }}" required></th>
                    </tr>
                    <tr>
                        <th><label for="address">Address:</label></th>
                        <th><input class="w-full text-gray-800 text-center bg-gray-100" type="text" id="address" name="address" value="{{ $user->address }}" required></th>
                    </tr>
                    <tr>
                        <th><label for="email">Email:</label></th>
                        <th><input class="w-full text-gray-800 text-center bg-gray-100" type="email" id="email" name="email" value="{{ $user->email }}" required></th>
                    </tr>
                        <!-- Password field is optional, but should not be pre-filled -->
                    <tr>
                        <th><label for="password">Password:</label></th>
                        <th> <input class="w-full text-gray-800 text-center bg-gray-100" type="password" id="password" name="password"></th>
                    </tr>
                    <tr>
                        <th><label for="position">Position:</label></th>
                        <th><input class="w-full text-gray-800 text-center bg-gray-100" type="text" id="position" name="position" value="{{ $user->position }}" required></th>
                    </tr>
                    <tr>
                        <th><label for="user_role">User Role:</label></th>
                        <th><input class="w-full text-gray-800 text-center bg-gray-100" type="text" id="user_role" name="user_role" value="{{ $user->user_role }}" required></th>
                    </tr>
                </table><th> <button type="submit">Update</button></th>      
            </form>                
            </div>
        </div>
    </div>

</x-app-layout>
