<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1 flex justify-between">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium text-gray-900">Tour Setting</h3>
                <p class="mt-1 text-sm text-gray-600"></p>
                <div class="mb-3">Manage your tour setting.</div>
            </div>
            <div class="class="px-4 sm:px-0""></div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                @if(Auth::user()->enable_tour == 0)
                <h3 class="text-lg font-medium text-gray-900">You didn't enable the tour feature.</h3>
                @else
                <h3 class="text-lg font-medium text-gray-900">You have enabled the tour feature.</h3>
                @endif
                <div class="mt-3 max-w-xl text-sm text-gray-600">
                    <p>When the tour feature is enabled, you can access it through the user dropdown and start the tour by clicking on the Start Tour button.</p>
                </div>
                <div class="mt-5">
                    <form action="{{ route('user.update-tour-settings') }}" method="POST">
                        @csrf
                        <div class="mt-6">
                            <label for="enable_tour" class="font-medium text-sm text-gray-700 flex items-center">
                                <span class="mr-2">Enable Tour :</span>
                                <input id="enable_tour" name="enable_tour" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" @if(Auth::user()->enable_tour) checked @endif>
                            </label>
                            @error('enable_tour')
                                <div class="text-red-600 mt-2 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        
                
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                {{ __('Save') }}
                            </button>
                            @if(session('success'))
                                <span class="ml-3 inline-flex items-center px-3 py-2 border rounded-md text-sm leading-4 font-medium text-indigo-700 bg-indigo-100 border-indigo-300">
                                    {{ session('success') }}
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    