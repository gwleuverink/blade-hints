<?php

namespace Leuverink\BladeHints\View;

use ErrorException;
use Illuminate\View\Compilers\BladeCompiler as Compiler;

class BladeCompiler extends Compiler
{
    use CompilesAuthorizations;
    use CompilesConditionals;

    /**
     * Disable view caching when BladeHints is enabled
     *
     * @throws ErrorException
     */
    public function isExpired($path)
    {
        if (config('blade-hints.enabled')) {
            return true;
        }

        return parent::isExpired($path);
    }

    private function openBladeHintsWrapper(string $label, string $type = 'authorization-if'): string
    {
        $label = str($label)
            ->replace("'", '')
            ->replace('"', '')
            ->toString();

        return <<< HTML
        <span class="blade-hints blade-hints__{$type}" data-blade-hints-label="{$label}">
        HTML;
    }

    private function closeBladeHintsWrapper(): string
    {
        return <<< 'HTML'
        </span>
        HTML;
    }
}
