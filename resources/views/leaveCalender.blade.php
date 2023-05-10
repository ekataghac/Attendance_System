<x-app-layout>
<div id="root"></div>
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

    <div class="grid-container dark:bg-gray-900">
        <div class="grid-item">
            <h3 class="font-semibold text-lg mb-2">View Holidays</h3>
            <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container ">
                <div class="p-4">
                    <div class="table-responsive">
                        <table class="table-auto min-w-full grid-itemalign">
                            <thead>
                                <tr>
                                    <th> Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>No. of Days</th>
                                    @cannot('user')
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    @endcannot
                                </tr>   
                            </thead>
                            <tbody>
                            @foreach($leaveCalenders as $leaveCalender)
                                @if($leaveCalender->name != 'Weekly Holiday')
                                    <tr>
                                        <td data-label="Leave">{{ $leaveCalender->name }}</td>
                                        <td data-label="Start Date">{{ $leaveCalender->start_date }}</td>
                                        <td  data-label="End Date">{{ $leaveCalender->end_date }}</td>
                                        <td  data-label="Number of days">{{ \Carbon\Carbon::parse($leaveCalender->start_date)->diffInDays(\Carbon\Carbon::parse($leaveCalender->end_date)) + 1 }}</td>
                                        @cannot('user')
                                        <td data-label="Edit"><a href="{{ route('editLeaveCalender', $leaveCalender->id) }}">Edit</a></td>
                                        <td  data-label="Delete">
                                        <form action="{{ route('deleteLeaveCalender', $leaveCalender->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">Delete</button>
                                        </form>
                                        </td>
                                        @endcannot
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @cannot('user')
        <div class="grid-item">
        <h3 class="font-semibold text-lg mb-2 green">Add Holidays</h3>
            <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container ">
                <div class="p-4">
                    <div class="table-responsive">
                        <form method="POST" action="{{ route('storeHoliday') }}">
                            @csrf
                            <table>
                                <tr>
                                    <th><label for="name">Holiday Name</label></th>
                                    <th><input type="text" class="form-control" id="name" name="name" required></th>
                                </tr>
                                <tr>
                                    <th><label for="start_date">Start Date</label></th>
                                    <th><input type="date" class="form-control" id="start_date" name="start_date" required></th>
                                </tr>
                                <tr>
                                    <th><label for="end_date">End Date</label></th>
                                    <th><input type="date" class="form-control" id="end_date" name="end_date" required></th>
                                </tr>
                            </table>
                            <br>
                            <button type="submit" class="btn btn-primary">Add Holiday</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endcannot
        <div class="grid-item">
        <h3 class="font-semibold text-lg mb-2">View Leave Categories</h3>
            <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container ">
                <div class="p-4">
                    <div class="table-responsive">
                        <table class="table-auto min-w-full">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Annual Entitlement</th>
                                    @cannot('user')
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    @endcannot
                                </tr>   
                            </thead>
                            <tbody>
                            @foreach($leaveCategories as $leaveCategory)
                                <tr>
                                    <td data-label="Category Name">{{ $leaveCategory->name }}</td>
                                    <td data-label="Annual Entitlement">{{ $leaveCategory->annual_entitlement }}</td>
                                    @cannot('user')
                                    <td data-label="Edit"><a href="{{ route('editLeaveCategory', $leaveCategory->id) }}">Edit</a></td>
                                    <td data-label="Delete">
                                        <form method="POST" action="{{ route('deleteLeaveCategory', $leaveCategory->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">Delete</button>
                                        </form>
                                    </td>
                                    @endcannot
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>  
        @cannot('user')
        <div class="grid-item">
        <h3 class="font-semibold text-lg mb-2 green">Add Leave Categories</h3>
            <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container ">
                <div class="p-4">
                    <div class="table-responsive">
                        <form method="POST" action="{{ route('storeLeaveCategory') }}">
                            @csrf
                            <table>
                                <tr>
                                    <th><label for="name">Name</label></th>
                                    <th><input type="text" class="form-control" id="name" name="name" required></th>
                                </tr>
                                <tr>
                                    <th><label for="annual_entitlement">Annual Entitlement</label></th>
                                    <th><input type="number" class="form-control" id="annual_entitlement" name="annual_entitlement" required></th>
                                </tr>
                            </table>
                            <br>
                            <button type="submit" class="btn btn-primary">Add Leave Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcannot
    @if(session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif
    <script type="text/javascript" src="{{ mix('js/app.js')}}"></script>
    <script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    // your code here
  });
</script>

</x-app-layout>
