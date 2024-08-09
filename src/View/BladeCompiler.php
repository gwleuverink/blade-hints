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
}
