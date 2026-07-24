<?php

namespace App\Providers;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend(
            HtmlSanitizerConfig::class,
            static fn (
                HtmlSanitizerConfig $config
            ): HtmlSanitizerConfig => $config
                ->allowAttribute(
                    'data-tooltip',
                    allowedElements: 'span',
                )
                ->allowAttribute(
                    'aria-label',
                    allowedElements: 'span',
                )
                ->allowAttribute(
                    'tabindex',
                    allowedElements: 'span',
                ),
        );
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make(
                'rich-content-plugins/tooltip',
                resource_path(
                    'js/filament/rich-content-plugins/tooltip.js'
                ),
            )->loadedOnRequest(),
            Js::make(
                'rich-content-plugins/text-color',
                resource_path(
                    'js/filament/rich-content-plugins/text-color.js'
                ),
            )->loadedOnRequest(),
        ]);

        RedirectIfAuthenticated::redirectUsing(function () {
            return route('account.settings');
        });
    }
}
