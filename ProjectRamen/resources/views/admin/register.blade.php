<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Left Side - Branding/Info Panel -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 relative overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-20 left-20 w-72 h-72 bg-yellow-200 rounded-full mix-blend-overlay filter blur-xl animate-blob"></div>
                <div class="absolute top-40 right-20 w-72 h-72 bg-red-300 rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-20 left-40 w-72 h-72 bg-orange-300 rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-4000"></div>
            </div>
            <div class="relative z-10 flex flex-col justify-center px-16 text-white">
                <div class="mb-8 flex flex-col items-center">
                    <h1 class="text-5xl font-bold mb-4 leading-tight text-yellow-200 drop-shadow-lg text-center">
                        RamenShop<br/>POS System
                    </h1>
                    <p class="text-xl text-yellow-100 leading-relaxed text-center">
                        Register an admin account to manage the system.<br>Only authorized personnel should create admin accounts.
                    </p>
                </div>
                <div class="space-y-4 mt-12">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-lg">Fast & secure registration</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-lg">Access to inventory & reporting</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-lg">Full control over products & staff</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-gray-50 dark:bg-slate-900">
            <div class="w-full max-w-md">

                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Create Admin Account
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Fill in the details for the admin user
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.register.submit') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Full Name</label>
                        <input 
                            type="text" name="name" value="{{ old('name') }}"
                            class="block w-full pl-4 pr-4 py-3.5 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            placeholder="Your Name" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Email Address</label>
                        <input 
                            type="email" name="email" value="{{ old('email') }}"
                            class="block w-full pl-4 pr-4 py-3.5 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            placeholder="you@example.com" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Password</label>
                        <input 
                            type="password" name="password"
                            class="block w-full pl-4 pr-4 py-3.5 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            placeholder="••••••••" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Confirm Password</label>
                        <input 
                            type="password" name="password_confirmation"
                            class="block w-full pl-4 pr-4 py-3.5 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            placeholder="••••••••" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                    </div>

                    <button 
                        type="submit"
                        class="w-full py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg transition transform hover:scale-[1.02] active:scale-[0.98]"
                    >
                        Create Admin Account
                    </button>

                    <a 
                        href="{{ route('register') }}"
                        class="w-full flex justify-center items-center py-3.5 border-2 border-gray-300 dark:border-gray-600 rounded-xl font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50"
                    >
                        Back
                    </a>

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
