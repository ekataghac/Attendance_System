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

    <div class="leave_css flex justify-center">
    <div class=" bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
        <h3 class="font-semibold text-lg mb-2">Edit Attendance Record</h3>
        <br>
        <div class="w-full lg:w-3/4 xl:w-1/2 flex flex-row">
        <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
            @csrf
            @method('PUT')
            <table class="table-add-usercss4">
                <tr>
                    <th><label for="date">Date</label></th>
                    <th><input type="date" class="form-control" id="date" name="date" value="{{ $attendance->date }}" readonly></th>
                </tr>
                <tr>
                    <th><label for="status">Status</label></th>
                    <th><input type="text" class="form-control" id="status" name="status" value="{{ $attendance->status }}" readonly></th>
                </tr>
                <tr>
                    <th><label for="check_in">Check In Time</label></th>
                    <th><input type="time" class="form-control" id="check_in" name="check_in" value="{{ $attendance->check_in }}" readonly></th>
                </tr>
                <tr>
                    <th><label for="check_out">Check Out Time</label></th>
                    <th><input type="time" class="form-control" id="check_out" name="check_out" value="{{ $attendance->check_out }}"></th>
                </tr>
                <tr>
                    <th><label for="remarks">Remarks</label></th>
                    <th><textarea class="form-control" id="remarks" name="remarks" required>{{ $attendance->remarks }}</textarea></th>
                </tr>
            </table>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
    </div>
</div>
</x-app-layout>
