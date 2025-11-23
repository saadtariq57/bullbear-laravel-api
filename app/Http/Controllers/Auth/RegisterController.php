<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailMailable;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function initiateSignUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $token = Str::random(60);
        
        $request->session()->put('initial_signup_data', [
            'name' => $request->name,
            'email' => $request->email,
            'token' => $token,
        ]);

        return response()->json(['token' => $token]);
    }

    public function showCompleteRegistrationForm(Request $request, $token)
    {
        $initialData = $request->session()->get('initial_signup_data');

        if (!$initialData || $initialData['token'] !== $token) {
            return redirect()->route('register')->with('error', 'Invalid or expired registration session.');
        }

        return view('auth.complete-registration', ['token' => $token]);
    }

    public function completeRegistration(Request $request)
    {
        $initialData = $request->session()->get('initial_signup_data');

        if (!$initialData || $initialData['token'] !== $request->token) {
            return redirect()->route('register')->with('error', 'Invalid or expired registration session.');
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_=+{};:,<.>]).{8,}$/'],
        ], [
            'password.regex' => 'The password must be at least 8 characters long and contain at least one special character, one uppercase letter, one lowercase letter, and one number.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = User::create([
            'name' => $initialData['name'],
            'email' => $initialData['email'],
            'password' => Hash::make($request->password),
            'subscription_plan_id' => 1,
        ]);

        $request->session()->forget('initial_signup_data');

        event(new Registered($user));

        return redirect()->route('verification.notice');
    }

    public function checkUsernameAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'regex:/^[a-zA-Z0-9]+$/', 'max:255'],
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'error' => true]);
        }
    
        $username = $request->input('username');
        $available = !User::where('name', $username)->exists();
        
        return response()->json(['available' => $available, 'requestedUsername' => $username]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_=+{};:,<.>]).{8,}$/'],
        ],[
            'password.regex' => 'The password must be at least 8 characters long and contain at least one special character, one uppercase letter, one lowercase letter, and one number.',
            'name.regex' => 'The username can only contain letters and numbers, no special characters or spaces.',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'subscription_plan_id' => 1,
        ]);
    }

    public function register(Request $request)
    {
        // Validate the incoming registration request
        $this->validator($request->all())->validate();

        // Create the user
        event(new Registered($user = $this->create($request->all())));

        // Retrieve period and plan_id from the request
        $period = $request->input('period');
        $plan_id = $request->input('plan_id');
        $allowedPeriods = ['monthly', 'yearly'];

        if ($period && $plan_id && in_array($period, $allowedPeriods) && $plan_id > 1) {
            $redirectUrl = "/{$period}/{$plan_id}/checkout";
            $request->session()->put('intended_checkout_url', $redirectUrl);
        }

        // Do not log the user in yet; require email verification
        return redirect('/email/verify')->with('email', $user->email);
    }

    protected function registered(Request $request, $user)
    {
        return redirect()->route('verification.notice');
    }
}