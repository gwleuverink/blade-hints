<?php

namespace Leuverink\BladeHints;

use Illuminate\Support\Arr;
use Leuverink\AssetInjector\Contracts\AssetInjector;

class InjectAssets implements AssetInjector
{
    public function identifier(): string
    {
        return 'BLADE_HINTS';
    }

    public function enabled(): bool
    {
        return true;
    }

    // Will inject return value in head tag or before html close if no head is present
    public function inject(): string
    {
        // Inject the assets in the response
        $js = file_get_contents(__DIR__ . '/../build/blade-hints.js');
        $css = file_get_contents(__DIR__ . '/../build/blade-hints.css');

        return <<< HTML
        <script type="module">{$js}</script>
        <style>
            {$this->theme()}
            {$css}
        </style>
        HTML;
    }

    protected function theme(): string
    {
        $variables = Arr::toCssStyles([
            '--bh-authorization-if-color:' . config('blade-hints.authorization_if_color'),
            '--bh-authorization-else-color:' . config('blade-hints.authorization_else_color'),

            '--bh-authentication-if-color:' . config('blade-hints.authentication_if_color'),
            '--bh-authentication-else-color:' . config('blade-hints.authentication_else_color'),

            '--bh-environment-if-color:' . config('blade-hints.environment_if_color'),

            '--bh-guest-if-color:' . config('blade-hints.guest_if_color'),
        ]);

        return ":root { {$variables} }";
    }
}
