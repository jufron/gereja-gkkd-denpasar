<?php

namespace App\Providers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (str_contains(request()->url(), 'ngrok-free.app')) {
            URL::forceScheme('https');
        }

        $this->registerActivityListeners();
    }

    /**
     * Record authentication events into the activity log.
     */
    private function registerActivityListeners(): void
    {
        Event::listen(Login::class, function (Login $event): void {
            activity('auth')
                ->causedBy($event->user)
                ->withProperties($this->requestContext())
                ->log('login');
        });

        Event::listen(Logout::class, function (Logout $event): void {
            activity('auth')
                ->causedBy($event->user)
                ->withProperties($this->requestContext())
                ->log('logout');
        });

        Event::listen(Failed::class, function (Failed $event): void {
            activity('auth')
                ->withProperties(array_merge($this->requestContext(), [
                    'email' => $event->credentials['email'] ?? null,
                ]))
                ->log('login_gagal');
        });

        Event::listen(Registered::class, function (Registered $event): void {
            activity('auth')
                ->causedBy($event->user)
                ->withProperties($this->requestContext())
                ->log('register');
        });

        Event::listen(PasswordReset::class, function (PasswordReset $event): void {
            activity('auth')
                ->causedBy($event->user)
                ->withProperties($this->requestContext())
                ->log('password_direset');
        });

        Event::listen(Lockout::class, function (Lockout $event): void {
            activity('auth')
                ->withProperties(array_merge($this->requestContext(), [
                    'email' => $event->request->input('email'),
                ]))
                ->log('terkunci');
        });
    }

    /**
     * Request context attached to every auth activity entry.
     *
     * @return array<string, mixed>
     */
    private function requestContext(): array
    {
        return [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
    }
}
