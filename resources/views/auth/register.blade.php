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
                        Create your <br>account
                    </h1>
                    <p class="text-teal-50 text-lg mb-8">
                        Join us to manage your vehicle access requests efficiently.
                    </p>
                </div>
            </div>

            <!-- Right Side: Register Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center">
                
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-800">Sign Up</h3>
                    <p class="text-gray-500 text-sm mt-1">Fill in your details to create an account</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input id="name" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block transition-colors" 
                               type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block transition-colors" 
                               type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@company.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block transition-colors"
                               type="password"
                               name="password"
                               required autocomplete="new-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input id="password_confirmation" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block transition-colors"
                               type="password"
                               name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all transform hover:scale-[1.02] mt-6">
                        SIGN UP
                    </button>

                    <!-- Login Link -->
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:text-teal-500">
                                Sign in
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>