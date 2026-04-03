<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fridah's Spice - Register</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Fridah's Spice" />
    <meta name="description" content="Fridah's Spice - Your one-stop shop for all spices" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/icons/favicon.ico') }}">

    <!-- Heroicons CDN for eye icons (you can also use your own SVG or font-awesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col justify-center items-center py-12 px-4">

    <!-- Form Container -->
    <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h2 class="text-center text-2xl font-extrabold text-gray-900 dark:text-gray-100 mb-6">
            Create Account
        </h2>

        <!-- Two-column Form -->
        <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @csrf

            <!-- First Name -->
            <div class="flex flex-col">
                <label for="firstname" class="text-gray-700 dark:text-gray-200">First Name</label>
                <input id="firstname" type="text" name="firstname" value="{{ old('firstname') }}" required autofocus
                       class="mt-1 rounded-md shadow-sm dark:border-gray-600 border border-gray-300 dark:bg-gray-700 w-full px-3 py-2" />
                @error('firstname')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Last Name -->
            <div class="flex flex-col">
                <label for="lastname" class="text-gray-700 dark:text-gray-200">Last Name</label>
                <input id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" required
                       class="mt-1 rounded-md shadow-sm dark:border-gray-600 border border-gray-300 dark:bg-gray-700 w-full px-3 py-2" />
                @error('lastname')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Email -->
            <div class="flex flex-col">
                <label for="email" class="text-gray-700 dark:text-gray-200">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 rounded-md shadow-sm dark:border-gray-600 border border-gray-300 dark:bg-gray-700 w-full px-3 py-2" />
                @error('email')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Phone -->
            <div class="flex flex-col">
                <label for="phone" class="text-gray-700 dark:text-gray-200">Phone Number</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                       class="mt-1 rounded-md shadow-sm dark:border-gray-600 border border-gray-300 dark:bg-gray-700 w-full px-3 py-2" />
                @error('phone')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- State -->
            <div class="flex flex-col">
                <label for="state_id" class="text-gray-700 dark:text-gray-200">Select State</label>
                <select id="state_id" name="state_id" required
                    class="mt-1 rounded-md shadow-sm dark:border-gray-600 border border-gray-300 dark:bg-gray-700 w-full px-3 py-2">
                    <option value="">-- Select State --</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                            {{ $state->title }}
                        </option>
                    @endforeach
                </select>
                @error('state_id')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password with toggle -->
            <div class="flex flex-col relative">
                <label for="password" class="text-gray-700 dark:text-gray-200">Password</label>
                <div class="relative mt-1">
                    <input id="password" type="password" name="password" required
                           class="rounded-md shadow-sm dark:border-gray-600 border border-gray-300 dark:bg-gray-700 w-full px-3 py-2 pr-10" />
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('password')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Confirm Password with toggle -->
            <div class="flex flex-col relative">
                <label for="password_confirmation" class="text-gray-700 dark:text-gray-200">Confirm Password</label>
                <div class="relative mt-1">
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="rounded-md shadow-sm dark:border-gray-600 border border-gray-300 dark:bg-gray-700 w-full px-3 py-2 pr-10" />
                    <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('password_confirmation')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Register Button + Login Link -->
            <div class="col-span-1 lg:col-span-2 flex flex-col lg:flex-row items-center justify-between mt-4">
                <a href="{{ route('login') }}"
                   class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 mb-3 lg:mb-0">
                    Already registered?
                </a>
                <button type="submit"
                        class="w-full lg:w-auto px-4 py-2 bg-green-600 text-white font-semibold rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Register
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript for toggle functionality -->
    <script>
        function setupPasswordToggle(inputId, toggleId) {
            const passwordInput = document.getElementById(inputId);
            const toggleButton = document.getElementById(toggleId);
            const icon = toggleButton.querySelector('i');

            toggleButton.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle eye icon
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }

        // Initialize both fields
        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle('password_confirmation', 'toggleConfirmPassword');
    </script>

</body>
</html>