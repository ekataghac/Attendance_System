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

    @cannot('user')
    <br>

        <div class="mx-auto add-usercss flex flex-col items-center ">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
                <h3 class="font-semibold text-lg green mb-2 text-green-900 ">Add User</h3>
                    <a href="{{ route('users.create') }}" class="btn-green btn btn-primary">Add User</a>
            </div>
        </div>


        <div class="mx-auto add-usercss flex flex-col items-center ">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
                <h3 class="font-semibold text-lg green mb-2 text-green-900 ">Edit Employee Details</h3>
                <div class="p-4 table-responsive">
                    <table class="table-auto min-w-full">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <!-- <th>Password</th> -->
                                <th>Position</th>
                                <th>Update Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td data-label="Name">{{ $user->first_name }}{{ $user->middle_name }}{{ $user->last_name }}</td>
                                    <td data-label="Address">{{ $user->address }}</td>
                                    <td data-label="Email">{{ $user->email }}</td>
                                    <!-- <td>{{ $user->password }}</td> -->
                                    <td data-label="Position">{{ $user->position }}</td>
                                    <td data-label="Edit or delete">
                                        <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded">
                                            Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700  font-bold py-2 px-4 rounded">Delete</button>
                                    </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <tfoot>                   
                            <div class="mt-4">
                                {{ $users->links() }}
                            </div>
                    </tfoot>
                </div>
            </div>
        </div>
    @endcannot
</x-app-layout>
