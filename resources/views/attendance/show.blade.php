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
            @if (count($attendance ?? []) > 0)    
                <h3 class="font-semibold text-lg mb-2">{{ $attendance[0]->user->first_name }} {{ $attendance[0]->user->last_name }}'s Weekly Attendance Report</h3><br>
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
                                @foreach ($attendance as $record)
                                    <tr>
                                        <td data-label="Date">{{ $record->date }}</td>
                                        <td data-label="Status">{{ $record->status }}</td>
                                        <td data-label="Check in">{{ $record->check_in }}</td>
                                        <td data-label="Check out">{{ $record->check_out }}</td>
                                        <td data-label="Remarks">{{ $record->remarks }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
            <p>No attendance records found for this user.</p>
            @endif
        </div>
    </div>

</x-app-layout>