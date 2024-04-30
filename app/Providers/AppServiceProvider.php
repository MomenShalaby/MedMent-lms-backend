<?php

namespace App\Providers;

use App\Models\Experience;
use App\Policies\ExperiencePolicy;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Validation\Rules\Password;

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
        // Password::defaults(function () {
        //     return Password::min(8)
        //         ->mixedCase()
        //         ->uncompromised()
        //         ->numbers()
        //         ->symbols();
        // });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Your Account Email for ABCDE')
                ->greeting("Dear $notifiable->fname $notifiable->lname,")
                ->line("Thank you for signing up with ABCDE! We're excited to have you join our community.")
                ->line("To complete the registration process and ensure the security of your account, please verify your email address by clicking on the link below:")
                ->action('Verify Email Address', $url)
                ->line("Please note that this link will expire in 60 minutes for security reasons. If you didn't register for an account with us, or if you believe this email was sent to you by mistake, please disregard it.")
                ->line('Thank you for choosing ABCDE. We look forward to providing you with a seamless and enjoyable experience.');
        });
    }
}
