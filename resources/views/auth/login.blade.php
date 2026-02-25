<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative bg-gray-50">
        
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/background-pkt.jpg') }}" 
                 alt="Background PKT" 
                 class="w-full h-full object-cover object-left md:object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-teal-900/90 to-blue-900/80"></div>
        </div>

        <!-- Login Container -->
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
                        Login to your <br>account
                    </h1>
                    <p class="text-teal-50 text-lg mb-8">
                        Welcome back! Please enter your details to access the dashboard.
                    </p>
                </div>
            </div>

            <!-- Right Side: Login Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center relative">
                
                <!-- Logos Container -->
                <div class="flex flex-row justify-center md:justify-center gap-6 mb-8 md:mb-10 items-center">
                    <img src="{{ asset('assets/images/logo-pkt.svg') }}" alt="Logo PKT" class="w-16 h-16 md:w-20 md:h-20 object-contain">
                    <img src="{{ asset('assets/images/logo-k3.svg') }}" alt="Logo K3" class="w-16 h-16 md:w-20 md:h-20 object-contain">
                    <img src="{{ asset('assets/images/logo-satpam.svg') }}" alt="Logo Satpam" class="w-16 h-16 md:w-20 md:h-20 object-contain">
                </div>

                <div class="mb-8 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-800">Sign In</h3>
                    <p class="text-gray-500 text-sm mt-1">Enter your email and password to sign in</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block transition-colors" 
                               type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@company.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-medium text-teal-600 hover:text-teal-500" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                        <input id="password" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block transition-colors"
                               type="password"
                               name="password"
                               required autocomplete="current-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500" name="remember">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all transform hover:scale-[1.02]">
                        SIGN IN
                    </button>

                    <!-- Register Link -->
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="font-medium text-teal-600 hover:text-teal-500">
                                Sign up
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>