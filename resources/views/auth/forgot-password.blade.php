<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fridah's Spice - Forgot Password</title>
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
                <img src="{{ asset('assets/images/logo-black.png') }}"
                     alt="Logo"
                     class="h-16 w-auto">
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">

            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-4">
                Forgot your password?
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 text-center">
                No problem. Enter your email address and we will send you a password reset link.
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-100 border border-green-400 text-green-700 px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email address
                    </label>

                    <input id="email"
                           name="email"
                           type="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                  focus:border-green-500 focus:ring-green-500
                                  dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2">

                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-md
                               hover:bg-green-700 focus:outline-none focus:ring-2
                               focus:ring-green-500 focus:ring-offset-2">
                    Email Password Reset Link
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