<x-app-layout>
    @if(session()->has('success'))
        <div>
            <p>{{session('success')}}</p>
        </div>
    @endif
<br><br>
    <div class="mx-auto add-attendancecss flex flex-col items-center">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 w-full lg:w-3/4 xl:w-1/2">
                <h3 class="font-semibold text-lg mb-2">Yearly Summarized Attendance of  {{$user->first_name}} {{$user->last_name}} of year {{$year}}</h3>
                <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                    <div class="p-4">
                        <div class="table-responsive">
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
                                        <td data-label="Present Days">Total Present days: {{ $present_days_in_year }} </td>
                                        <td data-label="Absent Days">Total Absent days: {{ $absent_days_in_year }}</td>
                                        <td data-label="Total Work Days">Total Working days: {{ $work_days_in_year }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><a href="{{ route('report') }}" class="btn btn-primary mt-4">{{ __('Back to View Report') }}</a>
                </div>
                </div>
            </div><br><br>
        </div>
        
</x-app-layout>