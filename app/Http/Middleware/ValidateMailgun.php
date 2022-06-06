<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateMailgun
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->hasRequiredFields($request)) {
            abort(403, 'Missing important headers');
        }

        if (!$this->validateMailgunToken($request)) {
            abort(403, 'Mailgun token does not match signing key');
        }

        return $next($request);
    }

    public function validateMailgunToken($request): bool
    {
        $timestamp = $request->input('timestamp');
        $token = $request->input('token');
        $key = config('mail.webhook.signing_key');

        $hash = hash_hmac("sha256", $timestamp . $token, $key, false);

        return $hash === $request->input('signature');
    }

    public function hasRequiredFields($request): bool
    {
        return $request->filled(['token','timestamp', 'signature']);
    }
}
