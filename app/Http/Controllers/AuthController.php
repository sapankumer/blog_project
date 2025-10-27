<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Exception;


class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validate and create user logic here
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        // User creation logic (omitted for brevity)
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        //$user->password = bcrypt($request->password);
        $user->password = Hash::make($request->password);
        $exist = User::latest()->get();
        if ($exist->isEmpty()) {
            $user->role = 'admin';
        } else {
            $user->role = 'user';
        }
        $user->save();
        flash()->success('Registration successful. You are now logged in.');
        Auth::login($user);
        return redirect()->route('posts.index');
    }

    public function login()
    {
        return view('auth.login');
    }

    function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Authentication passed...
            $request->session()->regenerate();
            flash()->success('Login successful.');
            return redirect()->intended('/');
        }
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // --- NEW GENERIC SOCIALITE METHODS ---

    /**
     * Redirect the user to the provider's authentication page.
     * @param string $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        // Check if the provider is valid
        if (!in_array($provider, ['facebook'])) {
            flash()->warning('Invalid login provider.');
            return redirect()->route('auth.login');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        // Check if the provider is valid
        if (!in_array($provider, ['facebook'])) {
            flash()->warning('Invalid login provider.');
            return redirect()->route('auth.login');
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
            $user = $this->findOrCreateUser($socialUser, $provider);

            Auth::login($user);
            flash()->success('Logged in successfully with ' . ucfirst($provider) . '.');
            return redirect()->route('posts.index'); // or redirect()->intended('/')

        } catch (Exception $e) {
            // You can log the error message here for debugging: \Log::error($e->getMessage());
            flash()->error('Something went wrong with ' . ucfirst($provider) . ' login.');
            return redirect()->route('auth.login');
        }
    }

    protected function findOrCreateUser($socialUser, $providerName)
    {
        // Check if user already exists with this provider
        $user = User::where('provider_id', $socialUser->id)
            ->where('provider_name', $providerName)
            ->first();

        if ($user) {
            // User already exists, just return them
            return $user;
        }

        // Check if user exists with this email
        $user = User::where('email', $socialUser->email)->first();

        if ($user) {
            // User exists, but not linked to this provider. Let's link them.
            $user->provider_name = $providerName;
            $user->provider_id = $socialUser->id;
            $user->avatar = $socialUser->avatar;
            $user->save();

            return $user;
        }

        // User does not exist at all. Create a new one.
        $newUser = new User();
        $newUser->name = $socialUser->name;
        $newUser->email = $socialUser->email;
        $newUser->password = null; // No password for social users
        $newUser->provider_name = $providerName;
        $newUser->provider_id = $socialUser->id;
        $newUser->avatar = $socialUser->avatar;

        // Your custom role logic
        $exist = User::latest()->get();
        if ($exist->isEmpty()) {
            $newUser->role = 'admin';
        } else {
            $newUser->role = 'user';
        }

        $newUser->save();

        return $newUser;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        flash()->success('You have been logged out.');
        return redirect('/');
    }

}
