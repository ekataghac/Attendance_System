<x-app-layout>
    @if(session()->has('success'))
        <div>
            <p>{{session('success')}}</p>
        </div>
    @endif
    <br>
    <br>
    @if(session('alert'))
        @if(session('alert-type') == 'success')
            <script>
                alert("{{ session('alert') }}");
            </script>
        @endif
    @endif

    <div class="leave_css flex justify-center">
        <div class="add-usercss2 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <h3 class="font-semibold text-lg mb-2">{{ __('Leave Record details of ') }} {{ $user->first_name }} {{ $user->last_name }} of year {{$year}}</h3>
            <br>
            <div class="w-full lg:w-3/4 xl:w-1/2 flex flex-row">
                @foreach($leaveCategories as $category)
                    <div class="flex-1">
                        <h3 class="text-lg mb-9"><u>{{ ucfirst($category->name) }} Record</u></h3>
                        <p>Total {{ ucfirst($category->name) }}: {{ $category->annual_entitlement }} days</p>
                        <p>{{ ucfirst($category->name) }} taken: {{ $leaveRequests->where('category_id', $category->id)->where('status', 'approved')->sum('duration') }} days</p>
                        <p>Total {{ ucfirst($category->name) }} remaining: {{ $category->annual_entitlement - $leaveRequests->where('category_id', $category->id)->where('status', 'approved')->sum('duration') }} days</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

<div class="leaveReq_css flex justify-center">
    <div class="add-usercss2 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
        <h3 class="font-semibold text-lg mb-2">View {{ $user->first_name }} {{ $user->last_name }}'s Leave Requests</h3>
        <div class="w-full lg:w-3/4 xl:w-1/2">
            <div class="p-4 table-responsive">
                <table class="table-auto min-w-full">
                @if ($leaveRequests->isEmpty())
                    There is no single Leave Request in the year {{$year}} 
                @else
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Leave Type</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($leaveRequests as $leave_request)
                        <tr>
                            <td>{{ $leave_request->user_id }}</td>
                            <td>{{ $leave_request->user->first_name }} {{ $leave_request->user->last_name }}</td>
                            <td>{{ $leave_request->start_date }}</td>
                            <td>{{ $leave_request->end_date}}</td>
                            <td>{{ $leave_request->leaveCategory->name }}</td>
                            <td>{{ $leave_request->reason }}</td>
                            <td>{{ ucfirst($leave_request->status) }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>


</x-app-layout>