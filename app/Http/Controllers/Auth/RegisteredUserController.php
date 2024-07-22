<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\CreateNewPasswordLinkController;
use App\Models\User;
use App\Models\PostGroup;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', ['postGroups' => PostGroup::all()]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required'],
            'post_groups' => ['array'],
            'post_groups.*' => ['exists:post_groups,id',]
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
            //test password - generated pass needs to be mailed to registered user
            'password' => Hash::make('test'),
        ]);

        if ($request->has('post_groups')) {
            $user->postGroups()->attach($request->post_groups);
        }

        NewUserRegistered::dispatch($user);
        $status = CreateNewPasswordLinkController::sendCreateNewLink(['email' => $user->email]);
        event(new Registered($user));

        // Auth::login($user);

        // return redirect(route('users.index', absolute: false))->with('status', $status);
        if($status == Password::CREATE_NEW_LINK_SENT)
        {
            return redirect(route('users.index', absolute: false ))->with('status', __($status));
        } else {
            return back()->withInput($user->email)->withErrors(['email' => __($status)]);
        }
    }
}
