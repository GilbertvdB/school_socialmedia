<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class CreateNewPasswordLinkController extends Controller
{

    /**
     * Handle the sending of the create new password link.
     */
    static public function sendCreateNewLink($email): string
    {   
        // We will send the create new password link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user.
        $status = Password::sendCreateNewLink($email);

        return $status;
    }
}
