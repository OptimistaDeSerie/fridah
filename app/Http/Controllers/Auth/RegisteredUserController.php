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
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $states = State::orderBy('title')->get();
        return view('auth.register', compact('states'));
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
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'], // <--- Add unique check
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'state_id' => ['required', 'exists:states,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $state = State::findOrFail($request->state_id);
        $deliveryFee = DeliveryFee::where('state_id', $state->id)->first();
        Address::create([
            'user_id'         => $user->id,
            'state_id'        => $state->id,  
            'delivery_fee_id' => $deliveryFee->id,
            'address'         => '',
            'type'            => 'home',
            'isdefault'       => 1,
        ]);

        event(new Registered($user));

        Auth::login($user);
        Mail::to($user->email)->send(new WelcomeMail($user));
        return redirect(route('index', absolute: false));
    }
}
