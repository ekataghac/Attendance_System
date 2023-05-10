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
        <h3 class="font-semibold text-lg mb-2">Edit Attendance Details</h3>
            <div class="w-full lg:w-3/4 xl:w-1/2">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <form action="{{ route('attendance.updateRecord', $attendance->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="date" value="{{ $attendance->date }}" required>
                </div>
                <div class="form-group">
                    <br><label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Present" @if ($attendance->status == 'Present') selected @endif>Present</option>
                        <option value="Absent" @if ($attendance->status == 'Absent') selected @endif>Absent</option>
                        <option value="Late" @if ($attendance->status == 'Late') selected @endif>Late</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="check_in">Check In Time</label>
                    <input type="text" class="form-control" name="check_in" value="{{ $attendance->check_in }}" required>
                </div>
                <div class="form-group">
                    <label for="check_out">Check Out Time</label>
                    <input type="text" class="form-control" name="check_out" value="{{ $attendance->check_out }}" required>
                </div>

                <div class="form-group">
                    <br><label for="remarks">Remarks</label>
                    <textarea class="form-control" name="remarks" rows="3">{{ $attendance->remarks }}</textarea>
                </div>
                <br><button type="submit" class="btn btn-primary">Update Record</button>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>
