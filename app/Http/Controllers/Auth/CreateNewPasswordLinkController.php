<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class CreateNewPasswordLinkController extends Controller
{

    /**
     * Handle the sending of the create new password link.
     */
    static public function sendCreateNewLink($email): string
    {   
        // sleep(10);
        // We will send the create new password link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user.
        $status = Password::sendCreateNewLink($email);

        return $status;
    }

    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'email' => ['required', 'email'],
    //     ]);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //     $status = Password::sendCreateNewLink(
    //         $request->only('email')
    //     );

    //     return $status == Password::CREATE_NEW_LINK_SENT
    //                 ? back()->with('status', __($status))
    //                 : back()->withInput($request->only('email'))
    //                         ->withErrors(['email' => __($status)]);
    // }
}
