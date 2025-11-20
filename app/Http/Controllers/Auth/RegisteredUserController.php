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
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validação
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', Rules\Password::defaults(), 'confirmed'],
        ]);

        // Criar usuário
        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        // Disparar evento de registro
        event(new Registered($user));

        // Logar usuário
        Auth::login($user);

        // Regenerar sessão
        $request->session()->regenerate();

        return to_route('dashboard');
    }
}
