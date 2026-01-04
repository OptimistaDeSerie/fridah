<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\State;
use App\Models\DeliveryFee;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 🔹 Dynamically get the first available State and DeliveryFee
        $firstState = State::first();           // Gets the first state in the table
        $firstDeliveryFee = DeliveryFee::first(); // Gets the first delivery fee record
        // 🔹 create a default address row for this user
        Address::create([
            'user_id'         => $user->id,
            'state_id'        => $firstState?->id,          // Safe: null if no states exist
            'delivery_fee_id' => $firstDeliveryFee?->id,    // Safe: null if no delivery fees exist
            'address'         => '',                        // Empty string instead of null (better for display)
            'type'            => 'home',
            'isdefault'       => 1,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('index', absolute: false));
    }
}
