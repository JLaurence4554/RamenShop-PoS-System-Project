<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Left Side - Branding/Info Panel -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob"></div>
                <div class="absolute top-40 right-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-20 left-40 w-72 h-72 bg-pink-300 rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-4000"></div>
            </div>

            <!-- Text Content -->
            <div class="relative z-10 flex flex-col justify-center px-16 text-white">
                <div class="mb-8">
                    <svg class="w-16 h-16 mb-6" viewBox="0 0 50 52" fill="currentColor">
                        <path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068z"/>
                    </svg>

                    <h1 class="text-5xl font-bold mb-4 leading-tight">
                        Create Your<br/>New Account
                    </h1>
                    <p class="text-xl text-indigo-100 leading-relaxed">
                        Join us and access powerful features instantly.
                    </p>
                </div>

                <!-- Feature List -->
                <div class="space-y-4 mt-12">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-lg">Fast & secure registration</span>
                    </div>

                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                        </svg>
                        <span class="text-lg">Access anywhere</span>
                    </div>

                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                        </svg>
                        <span class="text-lg">24/7 support</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-gray-50 dark:bg-slate-900">
            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="lg:hidden flex justify-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" viewBox="0 0 50 52" fill="currentColor">
                            <path d="M49.626 11.564..."/>
                        </svg>
                    </div>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Create Account
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Fill in your details to get started
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Full Name</label>
                        <input 
                            type="text" name="name" value="{{ old('name') }}"
                            class="block w-full pl-4 pr-4 py-3.5 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            placeholder="Your Name" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Email Address</label>
                        <input 
                            type="email" name="email" value="{{ old('email') }}"
                            class="block w-full pl-4 pr-4 py-3.5 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            placeholder="you@example.com" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Password</label>
                        <input 
                            type="password" name="password"
                            class="block w-full pl-4 pr-4 py-3.5 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            placeholder="••••••••" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Confirm Password</label>
                        <input 
                            type="password" name="password_confirmation"
                            class="block w-full pl-4 pr-4 py-3.5 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            placeholder="••••••••" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                    </div>

                    <!-- Register Button -->
                    <button 
                        type="submit"
                        class="w-full py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg transition transform hover:scale-[1.02] active:scale-[0.98]"
                    >
                        Create Account
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-gray-50 dark:bg-slate-900 text-gray-500 dark:text-gray-400">
                                Already have an account?
                            </span>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <a 
                        href="{{ route('login') }}"
                        class="w-full flex justify-center items-center py-3.5 border-2 border-gray-300 dark:border-gray-600 rounded-xl font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50"
                    >
                        Sign In
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- Animations -->
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</x-guest-layout>
