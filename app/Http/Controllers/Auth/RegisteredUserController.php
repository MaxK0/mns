<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $phone = $request->input('phone');

        if (!empty($phone)) {
            $phone = preg_replace("/[^0-9]/", "", $phone);
            $phone = substr($phone, 1);

            $request->merge(['phone' => $phone]);
        }

        $request->validate([
            'fio' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:'.User::class,
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'phone' => 'required|string|max:10|unique:'.User::class,
            'password' => ['required', 'confirmed', 'string', 'min:6', 'max:255'],
        ]);

        $request['password'] = Hash::make($request['password']);

        $user = User::create($request->all());

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('applications.index', absolute: false));
    }
}
