<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Inertia\Inertia;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // TODO: put logic here for admin login
        //https://laracasts.com/discuss/channels/laravel/version-8-redirects
        // $this->app->singleton(
        //     \Laravel\Fortify\Contracts\LoginResponse::class,
        //     \App\Http\Responses\LoginResponse::class
        // );

        Fortify::registerView(function () {
            // return view('auth.register');
            return Inertia::render('Auth/AuthRegister');
        });
        Fortify::loginView(function () {
            return Inertia::render('Auth/AuthLogin');
        });
        Fortify::verifyEmailView(fn () => Inertia::render('Auth/AuthEmailConfirmation'));
        Fortify::requestPasswordResetLinkView(fn () => Inertia::render('Auth/AuthPasswordResetLink'));
        Fortify::resetPasswordView(fn ($request) => Inertia::render('Auth/AuthResetPassword', [
            'request' => $request
        ]));

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
