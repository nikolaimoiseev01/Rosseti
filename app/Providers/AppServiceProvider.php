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
                )
                ->allowAttribute(
                    'class',
                    allowedElements: 'span',
                )
                ->allowAttribute(
                    'class',
                    allowedElements: 'img',
                )
                ->allowAttribute(
                    'data-checkmark',
                    allowedElements: 'img',
                )
                ->allowAttribute(
                    'data-color',
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
                'rich-content-plugins/checkmark',
                resource_path(
                    'js/filament/rich-content-plugins/checkmark.js'
                ),
            )->loadedOnRequest(),
        ]);

        // Fix: body overflow:hidden sticking after modal close
        \Filament\Support\Facades\FilamentView::registerRenderHook(
            \Filament\View\PanelsRenderHook::BODY_END,
            fn () => new \Illuminate\Support\HtmlString('
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const observer = new MutationObserver(function() {
                            const openModals = document.querySelectorAll("[x-ref=\"modalContainer\"]:not([style*=\"display: none\"]), .fi-modal-open");
                            if (openModals.length === 0) {
                                document.body.style.removeProperty("overflow");
                                document.documentElement.style.removeProperty("overflow");
                            }
                        });
                        observer.observe(document.body, { attributes: true, attributeFilter: ["style", "class"], childList: true, subtree: true });

                        // Also fix on Livewire events
                        document.addEventListener("livewire:navigated", function() {
                            document.body.style.removeProperty("overflow");
                            document.documentElement.style.removeProperty("overflow");
                        });
                        document.addEventListener("modal-closed", function() {
                            document.body.style.removeProperty("overflow");
                            document.documentElement.style.removeProperty("overflow");
                        });
                    });
                </script>
            '),
        );

        RedirectIfAuthenticated::redirectUsing(function () {
            return route('account.settings');
        });
    }
}
