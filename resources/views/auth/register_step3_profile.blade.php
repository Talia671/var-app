<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative bg-gray-50">
        
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/background-pkt.jpg') }}" 
                 alt="Background PKT" 
                 class="w-full h-full object-cover object-left md:object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-teal-900/90 to-blue-900/80"></div>
        </div>

        <!-- Register Container -->
        <div class="relative z-10 w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row m-4">
            
            <!-- Left Side: Welcome / Branding -->
            <div class="w-full md:w-1/2 bg-gradient-to-br from-teal-600 to-blue-700 p-8 md:p-12 text-white flex flex-col justify-center items-start relative overflow-hidden">
                <!-- Abstract Shapes -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>

                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-2">VAR SYSTEM</h2>
                    <p class="text-teal-100 text-sm tracking-widest font-semibold mb-6">VEHICLE ACCESS REQUEST</p>
                    
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                        Complete Profile
                    </h1>
                    <p class="text-teal-50 text-lg mb-8">
                        Step 3: Profile Information
                    </p>

                    <!-- Progress Indicator -->
                    <div class="flex items-center space-x-2 text-sm font-medium">
                        <span class="text-teal-200">Step 1</span>
                        <span class="text-teal-200">Step 2</span>
                        <span class="text-white bg-white/20 px-3 py-1 rounded-full">Step 3</span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Register Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center">
                
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-800">Profile Details</h3>
                    <p class="text-gray-500 text-sm mt-1">Complete your profile information</p>
                </div>

                <form method="POST" action="{{ route('register.profile.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Company / Department -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company / Department</label>
                        <input id="company" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block transition-colors" 
                               type="text" name="company" :value="old('company')" required autofocus placeholder="IT Department / PT. Vendor Name" />
                        <x-input-error :messages="$errors->get('company')" class="mt-1" />
                    </div>

                    <!-- NPK -->
                    <div>
                        <label for="npk" class="block text-sm font-medium text-gray-700 mb-1">NPK / No Badge (Optional)</label>
                        <input id="npk" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block transition-colors" 
                               type="text" name="npk" :value="old('npk')" placeholder="12345" />
                        <x-input-error :messages="$errors->get('npk')" class="mt-1" />
                    </div>

                    <!-- Photo -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Profile Photo (Optional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition-colors cursor-pointer" onclick="document.getElementById('photo').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-500">
                                        <span>Upload a file</span>
                                        <input id="photo" name="photo" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF up to 2MB
                                </p>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('photo')" class="mt-1" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all transform hover:scale-[1.02] mt-6">
                        COMPLETE REGISTRATION
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
