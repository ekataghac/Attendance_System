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
 <!-- to view the attendance details over years of themselves -->
    <div class="mx-auto add-attendancecss flex flex-col items-center">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
                <h3 class="font-semibold text-lg mb-2">View Your Attendance</h3>
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                    <div class="p-4">
                        <div class="table-responsive">
                            <form method="POST" action="{{ route('attendance.report') }}">
                                @csrf
                                @php
                                    $today = \Carbon\Carbon::today();
                                    $year = $today->year;
                                    $month = $today->month;
                                    $daysInMonth = $today->daysInMonth;
                                    $holidays = \App\Models\LeaveCalender::whereYear('start_date', $year)
                                                                            ->whereMonth('start_date', $month)
                                                                            ->get(['start_date']);
                                    $holidayDates = $holidays->pluck('start_date');
                                @endphp
                                <div class="form-group">
                                    <label for="year">Year:</label>
                                    <select class="form-control" id="year" name="year">
                                        @for ($i = 2015; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>Select month:</label>
                                        @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $index => $name)
                                            <label class="month-label">
                                                <input type="radio" class="month-radio" name="month" value="{{ $index + 1 }}" {{ $month == $index + 1 ? 'checked' : '' }}>
                                                {{ $name }}
                                            </label>
                                        @endforeach
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary"><u>Show Attendance</u></button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    @can('user')
    <br>
    @endcan
    @cannot('user')
    
<!-- to view Daily attendance of all users by the manager for that day -->
        <div class="mx-auto add-usercss flex flex-col items-center">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
                <h3 class="font-semibold text-lg mb-2 green">View Daily Attendance of All the Employees</h3>
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                    <div class="p-4">
                        <div class="table-responsive">                   
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td  data-label="Date">{{ $attendance->date }}</td>
                                        <td  data-label="Name">{{ $attendance->user->first_name }} {{ $attendance->user->last_name }}</td>
                                        <td  data-label="Position">{{ $attendance->user->position }}</td>
                                        <td  data-label="Status">{{ $attendance->status }}</td>
                                        <td  data-label="check in">{{ $attendance->check_in }}</td>
                                        <td  data-label="check out">{{ $attendance->check_out }}</td>
                                        <td  data-label="remarks">{{ $attendance->remarks }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    @endcannot

<!-- to view Weekly attendance of all users by the manager for that day -->
        <div class="mx-auto add-attendancecss flex flex-col items-center">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
            @cannot('user')
                <h3 class="font-semibold text-lg mb-2 green">View Weekly Attendance of Employees</h3>
            @endcannot
            @can('user')
                <h3 class="font-semibold text-lg mb-2">View Weekly Attendance</h3>
            @endcan
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                <form method="POST" action="{{ route('attendance.show') }}">
                    @csrf
                    <div class="p-4">
                        <label for="employee">Select Employee:</label>
                        <select name="employee" id="employee">
                        @cannot('user')
                            <option value="">Select an employee</option>
                        @endcannot
                            <option value="mine">Mine</option>
                            @cannot('user')
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                @endforeach
                            @endcannot
                        </select>
                    </div>
                    <div class="p-4">
                        <button type="submit" class="btn btn-primary"><u>View Weekly Attendance</u></button>
                    </div>
                </form>

                </div>
            </div>
        </div>
    @can('user')
    <br>
    @endcan
    @cannot('user')

    <!-- to view Yearly attendance of all users by the manager -->
        <div class="mx-auto add-usercss flex flex-col items-center">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
                <h3 class="font-semibold text-lg mb-2 green">View and Edit Yearly Attendance of all the Employees</h3>
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                    <div class="p-4">
                        <div class="table-responsive">
                            <form method="POST" action="{{ route('attendance.reportEmployee') }}">
                                @csrf
                                @php
                                    $today = \Carbon\Carbon::today();
                                    $year = $today->year;
                                    $month = $today->month;
                                    $daysInMonth = $today->daysInMonth;
                                    $holidays = \App\Models\LeaveCalender::whereYear('start_date', $year)
                                                                            ->whereMonth('start_date', $month)
                                                                            ->get(['start_date']);
                                    $holidayDates = $holidays->pluck('start_date');
                                @endphp
                                <div class="form-group">
                                    <label for="employee">Employee:</label>
                                    <select class="form-control" id="employee" name="employee">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id}}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="year">Year:</label>
                                    <select class="form-control" id="year" name="year">
                                        @for ($i = 2015; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select><br><br>
                                    <label>Select month:</label>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $index => $name)
                                    <label class="month-label">
                                    <input type="radio" class="month-radio" name="month" value="{{ $index + 1 }}" {{ $month == $index + 1 ? 'checked' : '' }}>
                                                        {{ $name }}
                                    </label>
                                    @endforeach
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary"><u>Show Attendance</u></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    @endcannot

    @cannot('user')
    <div class="mx-auto add-attendancecss flex flex-col items-center">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
                <h3 class="font-semibold text-lg mb-2 green">Yearly Summarized Attendance of All the Emlpoyes</h3>
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                    <div class="p-4">
                        <div class="table-responsive">
                            <form method="get" action="{{ route('attendance.summerizedReport') }}">
                            <label for="employee">Employee:</label>
                                    <select class="form-control" id="employee" name="employee">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id}}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                        @endforeach
                                    </select><br>
                                <label for="year">Year:</label>
                                <select name="year" id="year">
                                    @for ($y = date('Y'); $y >= 2010; $y--)
                                        <option value="{{ $y }}" @if ($y == $year) selected @endif>{{ $y }}</option>
                                    @endfor
                                </select>
                                <br><br>
                                <button type="submit" class="btn btn-primary"><u>Show Attendance</u></button>
                            </form>
                        </div>
                    </div>
                </div>

            </div><br><br>
        </div>
    @endcannot

    @cannot('user')
    <!-- to view Yearly attendance of user -->
        <div class="mx-auto add-attendancecss flex flex-col items-center">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
                <h3 class="font-semibold text-lg mb-2 green">View Yearly History of leave of All the Employees</h3>
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                    <div class="p-4">
                        <div class="table-responsive">
                            <form method="get" action="{{ route('leaveRecord') }}">
                                <label for="employee">Employee:</label>
                                <select class="form-control" id="employee" name="employee">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id}}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                        @endforeach
                                </select><br>
                                <label for="year">Year:</label>
                                <select name="year" id="year">
                                    @for ($y = date('Y'); $y >= 2010; $y--)
                                        <option value="{{ $y }}" @if ($y == $year) selected @endif>{{ $y }}</option>
                                    @endfor
                                </select>
                                <br><br>
                                <button type="submit" class="btn btn-primary"><u>Show Leave Report</u></button>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan


    @can('user')
    <!-- to view Yearly attendance of user -->
        <div class="mx-auto add-attendancecss flex flex-col items-center">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
                <h3 class="font-semibold text-lg mb-2">Your Yearly Summarized Attendance</h3>
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                    <div class="p-4">
                        <div class="table-responsive">
                            <form method="get" action="{{ route('report') }}">
                                <label for="year">Year:</label>
                                <select name="year" id="year">
                                    @for ($y = date('Y'); $y >= 2010; $y--)
                                        <option value="{{ $y }}" @if ($y == $year) selected @endif>{{ $y }}</option>
                                    @endfor
                                </select>
                                <br><br>
                                <button type="submit" class="btn btn-primary"><u>Show Attendance</u></button>
                            </form>
                            <br>
                            <table>
                                <thead>
                                    <th>Month</th>
                                    <th>Present Days</th>
                                    <th>Absent days</th>
                                    <th>Total Work Days</th>
                                </thead>
                                <tbody>
                                    @foreach($monthly_summary as $summary)
                                        <tr>
                                            <td data-label="Month">{{ $summary['month'] }}</td>
                                            <td data-label="Present Days">{{ $summary['present_days'] }}</td>
                                            <td data-label="Absent Days">{{ $summary['absent_days'] }}</td>
                                            <td data-label="Total Work Days">{{ $summary['total_work_days']}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td data-label="Total Present days">Total Present days: {{ $present_days_in_year }} </td>
                                        <td data-label="Total Absent days">Total Absent days: {{ $absent_days_in_year }}</td>
                                        <td data-label="Total Working days">Total Working days: {{ $work_days_in_year }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endcan
        
</x-app-layout>