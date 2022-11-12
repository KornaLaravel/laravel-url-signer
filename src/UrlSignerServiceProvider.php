<?php

namespace Spatie\UrlSigner\Laravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\UrlSigner\UrlSigner as BaseUrlSigner;

class UrlSignerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-url-signer')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $this->app->singleton(BaseUrlSigner::class, function ()  {
            $config = config('url-signer');

            return new UrlSigner(
                $config['signature_key'],
                $config['parameters']['expires'],
                $config['parameters']['signature']
            );
        });

        $this->app->alias(BaseUrlSigner::class, 'url-signer');
    }
}
