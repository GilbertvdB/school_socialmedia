<?php

namespace Illuminate\Contracts\Auth;

use Closure;

interface PasswordBroker
{
    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const RESET_LINK_SENT = 'passwords.sent';

    /**
     * Constant representing a successfully reset password.
     *
     * @var string
     */
    const PASSWORD_RESET = 'passwords.reset';

    /**
     * Constant representing a successfully newly created password.
     *
     * @var string
     */
    const PASSWORD_NEW = 'passwords.new';
    
    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    const INVALID_USER = 'passwords.user';

    /**
     * Constant representing an invalid token.
     *
     * @var string
     */
    const INVALID_TOKEN = 'passwords.token';

    /**
     * Constant representing a throttled reset attempt.
     *
     * @var string
     */
    const RESET_THROTTLED = 'passwords.throttled';

    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const CREATE_NEW_LINK_SENT = 'passwords.sent-new';

    /**
     * Send a password reset link to a user.
     *
     * @param  array  $credentials
     * @param  \Closure|null  $callback
     * @return string
     */
    public function sendResetLink(array $credentials, ?Closure $callback = null);

    /**
     * Send a create new password link to a user.
     *
     * @param  array  $credentials
     * @param  \Closure|null  $callback
     * @return string
     */
    public function sendCreateNewLink(array $credentials, ?Closure $callback = null);

    /**
     * Reset or create the password for the given token.
     *
     * @param  array  $credentials
     * @param  \Closure  $callback
     * @param  string  $status
     * @return mixed
     */
    public function reset(array $credentials, Closure $callback, string $status = 'RESET');
}
