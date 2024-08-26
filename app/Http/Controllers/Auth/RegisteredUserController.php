<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\CreateNewPasswordLinkController;
use App\Http\Requests\RegisteredUserStoreRequest;
use App\Models\User;
use App\Models\PostGroup;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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
    public function store(RegisteredUserStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        $user = User::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'email' => $validated['email'],
            // 'password' => Hash::make($request->password),
            'password' => Hash::make('test'),
        ]);

        if ($request->has('post_groups')) {
            $user->postGroups()->attach($request->post_groups);
        }

        NewUserRegistered::dispatch($user);
        $status = CreateNewPasswordLinkController::sendCreateNewLink(['email' => $user->email]);
        event(new Registered($user));

        if($status == Password::CREATE_NEW_LINK_SENT)
        {
            return redirect(route('users.index', absolute: false ))->with('status', __($status));
        } else {
            return back()->withInput($user->email)->withErrors(['email' => __($status)]);
        }
    }
}
