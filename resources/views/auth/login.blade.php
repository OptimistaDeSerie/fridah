<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fridah's Spice - Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Fridah's Spice" />
    <meta name="description" content="Fridah's Spice - Your one-stop shop for all spices" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/icons/favicon.ico') }}">
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col justify-center items-center py-12 px-4">
    <!-- Logo -->
    <div class="mb-8 flex justify-center">
        <a href="{{ route('index') }}">
            <img class="h-16 w-auto" src="{{ asset('assets/images/logo-black.png') }}" alt="Fridah spice Logo">
        </a>
    </div>

    <!-- Form Container -->
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h2 class="text-center text-2xl font-extrabold text-gray-900 dark:text-gray-100 mb-6">
            Log  In
        </h2>

        <!-- Session Status -->
        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div class="flex flex-col">
                <label for="email" class="text-gray-700 dark:text-gray-200">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 w-full px-3 py-2" />
                @error('email')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col">
                <label for="password" class="text-gray-700 dark:text-gray-200">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 w-full px-3 py-2" />
                @error('password')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                       class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-green-600 focus:ring-green-500 dark:focus:ring-green-600 dark:bg-gray-700">
                <label for="remember_me" class="ml-2 block text-sm text-gray-600 dark:text-gray-400">
                    Remember me
                </label>
            </div>

            <!-- Links & Submit -->
            <div class="flex flex-col lg:flex-row items-center justify-between mt-4 space-y-3 lg:space-y-0 lg:space-x-4">
                <div class="flex items-center space-x-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            Forgot your password?
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <span class="text-gray-600 dark:text-gray-400">|</span>
                        <a href="{{ route('register') }}"
                           class="underline text-sm text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300">
                            Register
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full lg:w-auto px-4 py-2 bg-green-600 text-white font-semibold rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Log in
                </button>
            </div>
        </form>
    </div>

</body>
</html>
