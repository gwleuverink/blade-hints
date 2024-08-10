<?php

namespace Leuverink\Glimpse\View;

use ErrorException;
use Illuminate\View\Compilers\BladeCompiler as Compiler;

class BladeCompiler extends Compiler
{
    use CompilesAuthorizations;
    use CompilesConditionals;

    /**
     * Disable view caching when Glimpse is enabled
     *
     * @throws ErrorException
     */
    public function isExpired($path)
    {
        if (config('glimpse.enabled')) {
            return true;
        }

        return parent::isExpired($path);
    }

    private function openGlimpseWrapper(string $label, string $type = 'authorization-if'): string
    {
        return <<< HTML
        <span class="glimpse glimpse__{$type}" data-glimpse-label="{$label}">
        HTML;
    }

    private function closeGlimpseWrapper(): string
    {
        return <<< 'HTML'
        </span>
        HTML;
    }
}
