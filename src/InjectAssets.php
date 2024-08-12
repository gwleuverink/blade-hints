<?php

namespace Leuverink\BladeHints;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\Events\RequestHandled;

class InjectAssets
{
    /** Injects a inline style tag containing BladeHints's CSS inside every full-page response */
    public function __invoke(RequestHandled $handled)
    {
        // No need to inject anything when BladeHints is disabled
        if (! config('blade-hints.enabled')) {
            return;
        }

        $html = $handled->response->getContent();

        // Skip if request doesn't return a full page
        if (! str_contains($html, '</html>')) {
            return;
        }

        // Skip if core was included before
        if (str_contains($html, '<!--[BLADE_HINTS-ASSETS]-->')) {
            return;
        }

        // Keep a copy of the original response
        $originalContent = $handled->response->original;

        // Inject the assets in the response
        $js = file_get_contents(__DIR__ . '/../build/blade-hints.js');
        $css = file_get_contents(__DIR__ . '/../build/blade-hints.css');

        $handled->response->setContent(
            $this->injectAssets($html, <<< HTML
            <!--[BLADE_HINTS-ASSETS]-->
            <script type="module">{$js}</script>
            <style>
                {$this->theme()}
                {$css}
            </style>
            <!--[ENDBLADE_HINTS]-->
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
            '--gl-authorization-if-color:' . config('blade-hints.authorization_if_color'),
            '--gl-authorization-else-color:' . config('blade-hints.authorization_else_color'),

            '--gl-authentication-if-color:' . config('blade-hints.authentication_if_color'),
            '--gl-authentication-else-color:' . config('blade-hints.authentication_else_color'),

            '--gl-environment-if-color:' . config('blade-hints.environment_if_color'),

            '--gl-guest-if-color:' . config('blade-hints.guest_if_color'),
        ]);

        return ":root { {$variables} }";
    }
}
