<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
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
        //
        Validator::extend('custom_mime_types', function ($attribute, $value, $parameters, $validator) {
        // Define the allowed mime types for video, image, and PDF
        $allowedMimeTypes = ['video/*', 'image/*', 'application/pdf'];

        // Check if the uploaded file's mime type is in the allowed list
        return in_array($value->getClientMimeType(), $allowedMimeTypes);
        });
    }
}
