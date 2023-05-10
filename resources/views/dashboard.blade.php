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

    @can('user')
    <br>
    @endcan

    @cannot('user')
    <!-- To view all the Employee Details  -->
    <div class="mx-auto add-usercss flex flex-col items-center ">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
        <h3 class="font-semibold text-lg green mb-2 text-green-900 toggle-table">View Employee Details</h3>
            <form method="POST" action="{{ route('attendance') }}">
                @csrf
                <table class= "table-container hidden">
                <caption>Employees Details</caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Address</th>
                        <th >Email</th>
                        <th>Position</th>
                        <th>User Role</th>
                    </tr>   
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td data-label="Name">{{ $user->first_name }} {{ $user->middle_name}} {{ $user->last_name }}</td>
                        <td data-label="Number">{{ $user->number }}</td>
                        <td data-label="Address">{{ $user->address }}</td>
                        <td data-label="Email">{{ $user->email }}</td>
                        <td data-label="Position">{{ $user->position }}</td>
                        <td data-label="User Role">{{ $user->user_role }}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </form>
        </div>
    </div>
    @endcannot

        

<!-- To make attendance by the user -->
    <div class="mx-auto add-attendancecss flex flex-col items-center">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
            <h3 class="font-semibold text-lg mb-2">Make Attendance</h3>
            <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                <div class="p-4">
                    <div class="table-responsive">
                    <form method="POST" action="{{ route('attendance') }}">
                        @csrf
                        <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Check in </th>
                                <th>Check out </th>
                                <th>Remarks</th>
                                <th>Submit Record</th>
                            </tr>
                        </thead>
                        <tbody>
                    @php
                        $today = \Carbon\Carbon::today();
                        $year = $today->year;
                        $month = $today->month;
                        $daysInMonth = $today->daysInMonth;
                        $startDate = \Carbon\Carbon::create($year, $month, 1);
                        $endDate = \Carbon\Carbon::create($year, $month, $daysInMonth);
                        $holidays = \App\Models\LeaveCalender::whereBetween('start_date', [$startDate, $endDate])
                            ->get(['start_date', 'end_date','name']);
                        $disabledDates = collect();

                        foreach ($holidays as $holiday) {
                            $disabledDates = $disabledDates->merge(\Carbon\CarbonPeriod::create(
                            $holiday->start_date,
                            $holiday->end_date
                            ));
                        }
    
                        $disabledDates = $disabledDates->merge(\Carbon\CarbonPeriod::create(
                            $startDate->copy()->subDay(),
                            $today
                        ));

                        $holidayDates = $holidays->pluck('start_date','name');
                    @endphp

                    @for ($date = $startDate; $date <= $endDate; $date->addDay())
                    @php
                        $disabled = $disabledDates->contains($date) || $date < $today || $holidayDates->contains($date->toDateString());

                        $attendance = \App\Models\AttendanceRecord::where('user_id', auth()->id())
                        ->whereDate('date', $date)
                        ->first();
                        $status = $attendance ? $attendance->status : '';
                        $subbtn = '';
                        $check_in = $attendance ? $attendance->check_in : '';
                        $check_out = $attendance ? $attendance->check_out : '';
                        $remarks = $attendance ? $attendance->remarks : '';

                        // Set remarks to holiday name if date is disabled due to being a holiday
                        if ($disabled && $holidayDates->has($date->toDateString())) {
                        $remarks = $holidayDates->get($date->toDateString());
                        }

                        $submitDisabled = $disabled || $attendance;
                        $editDisabled = $disabled || !$attendance || $date > $today;

                        // New variable to determine if current column is submit column
                        $isSubmitColumn = $date->toDateString() === $today->toDateString();
                    @endphp
                    <tr>
                        <td  data-label="Date">
                        <input type="date" name="date[]" {{ $disabled ? 'disabled' : 'readonly' }} value="{{ $date->toDateString() }}">
                        </td>
                        <td  data-label="Status">
                        @if ($disabled)
                        {{ (string)$status ?: '-' }}

                        @else
                            @if(!$attendance)
                            <select name="status[]" {{ $date->toDateString() !== $today->toDateString() ? 'disabled' : '' }}>
                                <option value="present" {{ $status === 'present' ? 'selected' : '' }}>Present</option>
                                <option value="absent" {{ $status === 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="late" {{ $status === 'late' ? 'selected' : '' }}>Late</option>
                            </select>                          
                            @else
                            <input type="text" name="status[]" value="{{ $status }}" {{ $date->toDateString() !== $today->toDateString() ? 'disabled' : 'readonly' }} >
                            @endif

                        @endif
                        </td>
                        <td  data-label="Check in">
                        @if ($disabled)
                            {{ (string)$check_in ?: '-' }}
                        @else
                            @if(!$attendance)
                                <input type="time" name="check_in[]" value="{{ $check_in }}" {{ $date->toDateString() !== $today->toDateString() ? 'disabled' : '' }} />
                            @else
                            <input type="time" name="check_in[]" value="{{ $check_in }}" {{ $date->toDateString() !== $today->toDateString() ? 'disabled' : 'readonly' }} />
                            @endif

                        @endif
                        </td>
                        <td  data-label="Check out">
                        @if ($disabled)
                            {{ (string)$check_out ?: '-' }}
                        @else
                            @if(!$attendance)
                                <input type="time" name="check_out[]" value="{{ $check_out }}" {{ $date->toDateString() !== $today->toDateString() ? 'disabled' : '' }} />
                            @else
                                <input type="time" name="check_out[]" value="{{ $check_out }}" {{ $date->toDateString() !== $today->toDateString() ? 'disabled' : 'readonly' }} />
                            @endif
                        @endif
                        </td>
                        <td  data-label="Remarks" >
                        @if ($disabled)
                            {{ (string)$remarks ?: '-' }}
                        @else
                            @if(!$attendance)
                                <input type="text" name="remarks[]" value="{{ $remarks }}" {{ $date->toDateString() !== $today->toDateString() ? 'disabled' : '' }} />
                            @else
                                <input type="text" name="remarks[]" value="{{ $remarks }}" {{ $date->toDateString() !== $today->toDateString() ? 'disabled' : 'readonly' }} />
                            @endif
                        @endif
                        </td>
                        <td >
                        @if ($disabled)
                        {{ (string)$subbtn ?: '-' }}
                        @else
                        @if ($isSubmitColumn && $attendance)
                        {{ (string)$subbtn ?: 'Attendence Submitted' }}
                        @else
                            <button type="submit" {{ $date->toDateString() !== $today->toDateString() ? 'disabled' : '' }}>Submit</button>
                        @endif
                        @endif
                    </td>
                        @if ($date === $today->day)
                        <td>

                        @if ($attendance)
                            <a href="{{ route('attendance.edit', ['id' => $attendance->id]) }}" data-toggle="modal" data-target="#editAttendanceModal{{ $attendance->id }}" {{ $editDisabled ? 'disabled' : '' }}>Edit</a>
                            <!-- Edit attendance modal code... -->
                        
                        @endif

                        </td>
                        @endif
                        

                    </tr>
                            @endfor
                        </tbody>

                        </table>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get the "Employee Details" heading
        const toggleTableHeading = document.querySelector('.toggle-table');
        // Get the table container
        const tableContainer = document.querySelector('.table-container');
        // Add a click event listener to the heading
        toggleTableHeading.addEventListener('click', () => {
            // Toggle the visibility of the table container
            tableContainer.classList.toggle('hidden');
        });
    </script>
    @if(session('error'))
    <script>
        alert('{{ session('error') }}');
    </script>
    @endif

</x-app-layout>