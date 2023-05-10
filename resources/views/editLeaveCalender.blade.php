@can('user')
    <h1>YOU ARE NOT AUTHORIZED FOR THIS PAGE GO BACK!!</h1>
@endcan
@cannot('user')
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
    <div class="p-6">
        <div class="add-usercss3 flex flex-wrap">
            <div class="w-full md:w-1/3 px-4 py-2">
                <!-- Employees Details Display -->
                <div class="adduserbutton py-6 ">
                    <div class="px-4">
                        <div class=" add-usercss4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg mb-2">Edit Hoilday Details</h3>
                            <div class="w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 table-container">
                            <form method="POST" action="{{ route('updateLeaveCalender.update', $leaveCalender->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <table>
                                <tr>
                                    <th><label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Holiday Name') }}</label></th>
                                    <th>
                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $leaveCalender->name }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th><label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }}</label></th>
                                    <th>
                                        <div class="col-md-6">
                                            <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ $leaveCalender->start_date }}" required autocomplete="start_date">

                                            @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th><label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }}</label></th>
                                    <th>
                                        <div class="col-md-6">                                    
                                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ $leaveCalender->end_date }}" required autocomplete="end_date">
                                            @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            </div>
                                    </th>

                                </tr>
                            </table>                    
                            <br>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcannot


</x-app-layout>
