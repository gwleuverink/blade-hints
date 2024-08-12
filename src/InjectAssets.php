<?php

namespace Leuverink\Glimpse;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\Events\RequestHandled;

class InjectAssets
{
    /** Injects a inline style tag containing Glimpse's CSS inside every full-page response */
    public function __invoke(RequestHandled $handled)
    {
        // No need to inject anything when Glimpse is disabled
        if (! config('glimpse.enabled')) {
            return;
        }

        $html = $handled->response->getContent();

        // Skip if request doesn't return a full page
        if (! str_contains($html, '</html>')) {
            return;
        }

        // Skip if core was included before
        if (str_contains($html, '<!--[GLIMPSE-ASSETS]-->')) {
            return;
        }

        // Keep a copy of the original response
        $originalContent = $handled->response->original;

        // Inject the assets in the response
        $js = file_get_contents(__DIR__ . '/../build/glimpse.js');
        $css = file_get_contents(__DIR__ . '/../build/glimpse.css');

        $handled->response->setContent(
            $this->injectAssets($html, <<< HTML
            <!--[GLIMPSE-ASSETS]-->
            <script type="module">{$js}</script>
            <style>
                {$this->theme()}
                {$css}
            </style>
            <!--[ENDGLIMPSE]-->
            HTML)
        );

        $handled->response->original = $originalContent;
    }

    /** Injects Bundle's core into given html string (taken from Livewire's injection mechanism) */
    protected function injectAssets(string $html, string $core): string
    {
        $html = str($html);

        if ($html->test('/<\s*\/\s*head\s*>/i')) {
            return $html
                ->replaceMatches('/(<\s*\\s*head\s*>)/i', '$1' . $core)
                ->toString();
        }

        return $html
            ->replaceMatches('/(<\s*html(?:\s[^>])*>)/i', '$1' . $core)
            ->toString();
    }

    protected function theme(): string
    {
        $variables = Arr::toCssStyles([
            '--gl-authorization-if-color:' . config('glimpse.authorization_if_color'),
            '--gl-authorization-else-color:' . config('glimpse.authorization_else_color'),

            '--gl-authentication-if-color:' . config('glimpse.authentication_if_color'),
            '--gl-authentication-else-color:' . config('glimpse.authentication_else_color'),

            '--gl-environment-if-color:' . config('glimpse.environment_if_color'),

            '--gl-guest-if-color:' . config('glimpse.guest_if_color'),
        ]);

        return ":root { {$variables} }";
    }
}
