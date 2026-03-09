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
                        Verify Token
                    </h1>
                    <p class="text-teal-50 text-lg mb-8">
                        Step 2: Admin Token Verification
                    </p>

                    <!-- Progress Indicator -->
                    <div class="flex items-center space-x-2 text-sm font-medium">
                        <span class="text-teal-200">Step 1</span>
                        <span class="text-white bg-white/20 px-3 py-1 rounded-full">Step 2</span>
                        <span class="text-teal-200">Step 3</span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Register Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center">
                
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-800">Token Verification</h3>
                    <p class="text-gray-500 text-sm mt-1">Enter the registration token provided by admin</p>
                </div>

                <form method="POST" action="{{ route('register.token.store') }}" class="space-y-4">
                    @csrf

                    <!-- Token -->
                    <div>
                        <label for="token" class="block text-sm font-medium text-gray-700 mb-1">Registration Token</label>
                        <input id="token" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block transition-colors font-mono tracking-wider uppercase" 
                               type="text" name="token" :value="old('token')" required autofocus placeholder="XXXX-XXXX-XXXX" />
                        <x-input-error :messages="$errors->get('token')" class="mt-1" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all transform hover:scale-[1.02] mt-6">
                        VERIFY TOKEN →
                    </button>

                    <!-- Back Link -->
                    <div class="text-center mt-6">
                        <a href="{{ route('register') }}" class="text-sm font-medium text-gray-600 hover:text-teal-600">
                            ← Back to Step 1
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
