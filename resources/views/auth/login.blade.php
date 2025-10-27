<x-layout>
    <x-slot:title>
        Login
    </x-slot>
    <main>
        <div class="w-3/4 md:w-1/2 lg:w-1/3 mx-auto mt-10 p-6 bg-white rounded shadow-lg">
            <div class="flex items-center justify-between mb-6 px-10">
                <h1 class="text-2xl font-bold mb-4">Login</h1>
                <a href="{{ route('posts.index') }}">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                    </svg>

                </a>
            </div>

            <div class="px-8 space-y-4">
                <a href="{{route('auth.provider', 'google')}}"
                   class="flex items-center justify-center w-full bg-white border border-gray-300 rounded shadow-sm px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <svg class="mr-2 -ml-1 w-5 h-5" aria-hidden="true" focusable="false" data-prefix="fab"
                         data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                        <path fill="currentColor"
                              d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 126 23.4 172.9 61.9l-65.7 64.9C337 97.2 297.6 80 248 80 149.1 80 68.8 161.2 68.8 260.1s80.3 180.1 179.2 180.1c103.2 0 162.1-71.8 167.5-120.3H248v-85.3h236.1c2.3 12.7 3.9 26.4 3.9 41z"></path>
                    </svg>
                    Continue with Google
                </a>

                <a href="{{route('auth.provider', 'facebook')}}"
                   class="flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm px-4 py-2 text-sm font-medium">
                    <svg class="mr-2 -ml-1 w-5 h-5" aria-hidden="true" focusable="false" data-prefix="fab"
                         data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path fill="currentColor"
                              d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                    </svg>
                    Continue with Facebook
                </a>
            </div>

            <div
                class="my-4 flex items-center px-8 before:flex-1 before:border-t before:border-gray-300 before:mt-0.5 after:flex-1 after:border-t after:border-gray-300 after:mt-0.5">
                <p class="text-center text-xs font-semibold text-gray-500 mx-4 mb-0">OR</p>
            </div>

            <form method="POST" action="{{ route('auth.postLogin') }}" class="  px-8 pt-6 pb-8 mb-4">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @if ($errors->has('email'))
                        <p class="text-red-500 text-xs italic mt-2">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-6">
                    <input type="checkbox" name="remember" id="remember" class="mr-2 leading-tight">
                    <label for="remember" class="text-sm text-gray-700">Remember Me</label>
                </div>

                <div class="flex items-center justify-between gap-4 flex-col">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Login
                    </button>
                    <p>Don't You have any Account? Please
                        <a href="{{ route('auth.register') }}"
                           class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Register
                        </a>
                    </p>
                </div>
        </div>
    </main>
</x-layout>
