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
    <br>
<!-- To make attendance by the user -->
    <div class="mx-auto add-attendancecss flex flex-col items-center">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
            <h3 class="font-semibold text-lg mb-2">View Your Attendance</h3><br>
            <u><h3>Attendance Report for {{ date('F Y', strtotime($year . '-' . $month . '-01')) }}</h3></u>
            <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                <div class="p-4">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Check in Time</th>
                                <th>Check out Time</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $user_id = auth()->id();
                                // get the selected year and month from the form
                                $year = request()->input('year');
                                $month = request()->input('month');

                                // get the number of days in the selected month
                                $daysInMonth = \Carbon\Carbon::create($year, $month)->daysInMonth;

                                // get the attendance records for the selected year and month
                                $attendances = \App\Models\AttendanceRecord::where('user_id', $user_id)
                                    ->whereMonth('date', $month)
                                    ->whereYear('date', $year)
                                    ->orderBy('date')
                                    ->get();

                                // create an array of the attendance dates for the selected month
                                                $attendanceDates = $attendances->pluck('date')->toArray();
                            @endphp

                            @for($i=1; $i<=$daysInMonth; $i++)
                                @php
                                $date = \Carbon\Carbon::create($year, $month, $i)->format('Y-m-d');

                                    $attendance = $attendances->firstWhere('date', $date);
                                @endphp
            
                                <tr>
                                    <td data-label="Date">{{ $date }}</td>
                                    @if(in_array($date, $attendanceDates))
                                        <td data-label="Status">{{ $attendance->status }}</td>
                                        <td data-label="Check in">{{ $attendance->check_in }}</td>
                                        <td data-label="Check out">{{ $attendance->check_out }}</td>
                                        <td data-label="Remarks">{{ $attendance->remarks }}</td>
                                    @else
                                    <td data-label="Status">-</td>
                                    <td data-label="Check in">-</td>
                                    <td data-label="Check out">-</td>
                                    <td data-label="Remarks">-</td>
                                    @endif
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{ route('report') }}" class="btn btn-primary mt-4">{{ __('Back to View Report') }}</a>
        </div>
    </div>

</x-app-layout>