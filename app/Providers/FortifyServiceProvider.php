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

class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // untuk melakukan load view login.blade.php
        // untuk proses login
        Fortify::loginView(function () {
            return view('auth.login');
        });
        
        // untuk melakukan load view forgot-password.blade.php
        // untuk mengirim link reset password
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });
        
        // untuk melakukan load view reset
        // Setelah link berhasil dikirim melalui email, maka kita akan melakukan update password.
        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });
        
        // untuk melakukan load view confirm password
        // untuk verifikasi saat kita ingin mengaktifkan fitur two factor authentication.
        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });
        
        // untuk melakukan load view two factor authentication
        // Halaman ini akan muncul, jika kita mengaktifkan fitur two factor authentication dan melakukan proses login.
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });
    }
}
