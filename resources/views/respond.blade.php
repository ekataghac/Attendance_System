<x-app-layout>
    </x-slot>
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
    <div class=" mx-auto leavecss flex justify-center">
        <div class="leave-requestcss bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <div class="w-full lg:w-3/4 xl:w-1/2">
            <h3 class="font-semibold text-lg mb-2">Respond to the Leave Request</h3>
            <br>
            <form method="POST" action="{{ route('leaveRequest.respond.update', ['id' => $leaveRequest->id]) }}">
                                <!-- Form fields go here -->
                                @csrf
                                @method('PUT')
                                    <!-- Status Type -->                
                                    <div class="w-60">
                                        <x-input-label for="status" :value="__('Status')" />
                                        <select id="status" name="status" class="block mt-1 w-full" :value="old('status')" required autofocus autocomplete="status">
                                                    <option value="approved">Approved</option>
                                                    <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                    <br>
                                    <!-- Reason -->                
                                    <div class="w-60">
                                        <x-input-label for="reason" :value="__('Reason of Acceptence or Rejection')" />
                                        <x-text-input id="reason" class="block mt-1 w-full" type="text" name="reason" :value="old('reason')" autofocus autocomplete="reason" />
                                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary">submit</button>
                                </div>
            </form>  
            </div>
        </div>
    </div>

</x-app-layout>
