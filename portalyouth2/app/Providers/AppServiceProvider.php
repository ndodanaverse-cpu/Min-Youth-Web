<?php

namespace App\Providers;

use App\Services\AuditService;
use App\Services\OtpService;
use App\Services\SettingsService;
use App\Services\Sms\Contracts\SmsSender;
use App\Services\Sms\Drivers\LogSmsSender;
use App\Services\Sms\Drivers\TwilioSmsSender;
use App\Services\Sms\SmsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsService::class);
        $this->app->singleton(AuditService::class);
        $this->app->singleton(OtpService::class);
        $this->app->singleton(SmsService::class);

        $this->app->bind(SmsSender::class, function () {
            return match (config('sms.default')) {
                'twilio' => new TwilioSmsSender,
                default => new LogSmsSender,
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
