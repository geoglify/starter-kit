<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use LdapRecord\Connection;
use Illuminate\Support\Facades\Log;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('email', 'password');

        $connection = new Connection([
            'hosts' => [env('LDAP_HOST', '127.0.0.1')],
            'username' => env('LDAP_USERNAME', 'cn=user,dc=local,dc=com'),
            'password' => env('LDAP_PASSWORD', 'secret'),
            'port' => env('LDAP_PORT', 389),
            'base_dn' => env('LDAP_BASE_DN', 'dc=local,dc=com'),
            'timeout' => env('LDAP_TIMEOUT', 5),
            'use_ssl' => env('LDAP_SSL', false),
            'use_tls' => env('LDAP_TLS', false),
            'use_sasl' => env('LDAP_SASL', false)
        ]);

        // Append domain to email if not present
        if (strpos($credentials['email'], '@') === false) {
            $credentials['email'] .= '@' . env('LDAP_DOMAIN', 'local.com');
        }

        $ldap_is_ready = false;

        try {
            $connection->connect();
            $ldap_is_ready = true;
        } catch (\LdapRecord\Auth\BindException $e) {
            Log::error('LDAP connection failed: ' . $e->getMessage());
        }

        // Attempt LDAP authentication first before falling back to database authentication
        if ($ldap_is_ready && $connection->auth()->attempt($credentials['email'], $credentials['password'], $this->boolean('remember'))) {

            // Check if user exists in database
            $user = User::where('email', $credentials['email'])->first();

            // If user exists, authenticate user
            if ($user) {
                Auth::login($user, $this->boolean('remember'));

                $this->clearRateLimiter();
                return;
            }
        }

        // Fallback to default database authentication
        if (Auth::attempt($credentials, $this->boolean('remember'))) {
            $this->clearRateLimiter();
            return;
        }

        // If both LDAP and database authentication fail
        $this->incrementRateLimiter();

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Clear the rate limiter for the current request.
     */
    protected function clearRateLimiter(): void
    {
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Increment the rate limiter for the current request.
     */
    protected function incrementRateLimiter(): void
    {
        RateLimiter::hit($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
