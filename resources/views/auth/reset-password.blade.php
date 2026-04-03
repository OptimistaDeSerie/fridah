<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fridah's Spice - Reset Password</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Fridah's Spice" />
    <meta name="description" content="Fridah's Spice - Your one-stop shop for all spices" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/icons/favicon.ico') }}">
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('index') }}">
                <img class="h-16 w-auto" src="{{ asset('assets/images/logo-black.png') }}" alt="Fridah spice Logo">
            </a>
        </div>
        <!-- Card -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-6">
                Reset your password
            </h2>
            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf
                <!-- Token -->
                <input type="hidden" name="token" value="{{ request()->route('token') }}">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email address
                    </label>
                    <input id="email"
                           name="email"
                           type="email"
                           value="{{ old('email', request()->email) }}"
                           required
                           autofocus
                           autocomplete="username"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                  focus:border-green-500 focus:ring-green-500
                                  dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2">

                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        New password
                    </label>
                    <input id="password"
                           name="password"
                           type="password"
                           required
                           autocomplete="new-password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                  focus:border-green-500 focus:ring-green-500
                                  dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2">

                    @error('password')
                        <span class="text-red-500 text-sm mt-1 block">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Confirm password
                    </label>
                    <input id="password_confirmation"
                           name="password_confirmation"
                           type="password"
                           required
                           autocomplete="new-password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                  focus:border-green-500 focus:ring-green-500
                                  dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2">

                    @error('password_confirmation')
                        <span class="text-red-500 text-sm mt-1 block">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <!-- Submit -->
                <button type="submit"
                        class="w-full mt-2 px-4 py-2 bg-green-600 text-white font-semibold rounded-md
                               hover:bg-green-700 focus:outline-none focus:ring-2
                               focus:ring-green-500 focus:ring-offset-2">
                    Reset Password
                </button>
            </form>
            <!-- Back to login -->
            <div class="text-center mt-6">
                <a href="{{ route('login') }}"
                   class="text-sm text-green-600 hover:text-green-700 underline">
                    Back to login
                </a>
            </div>
        </div>
    </div>
</body>
</html>