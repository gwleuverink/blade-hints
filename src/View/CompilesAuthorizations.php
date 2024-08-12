<?php

namespace Leuverink\BladeHints\View;

use Illuminate\View\Compilers\Concerns\CompilesAuthorizations as Original;

trait CompilesAuthorizations
{
    use Original {
        Original::compileCan as originalCompileCan;
        Original::compileCannot as originalCompileCannot;
        Original::compileCanany as originalCompileCanany;
        Original::compileElsecan as originalCompileElsecan;
        Original::compileElsecannot as originalCompileElsecannot;
        Original::compileElsecanany as originalCompileElsecanany;
        Original::compileEndcan as originalCompileEndcan;
        Original::compileEndcannot as originalCompileEndcannot;
        Original::compileEndcanany as originalCompileEndcanany;
    }

    abstract private function openBladeHintsWrapper(string $label): string;

    abstract private function closeBladeHintsWrapper(): string;

    /**
     * Compile the can statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileCan($expression)
    {
        if (! config('blade-hints.authorization_directives')) {
            return $this->originalCompileCan($expression);
        }

        return $this->originalCompileCan($expression) . PHP_EOL .
            $this->openBladeHintsWrapper("can{$expression}", 'authorization-if');
    }

    /**
     * Compile the cannot statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileCannot($expression)
    {
        if (! config('blade-hints.authorization_directives')) {
            return $this->originalCompileCannot($expression);
        }

        return $this->originalCompileCannot($expression) . PHP_EOL
            . $this->openBladeHintsWrapper("cannot{$expression}", 'authorization-if');
    }

    /**
     * Compile the canany statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileCanany($expression)
    {
        if (! config('blade-hints.authorization_directives')) {
            return $this->originalCompileCanany($expression);
        }

        return $this->originalCompileCanany($expression) . PHP_EOL
            . $this->openBladeHintsWrapper("canany{$expression}", 'authorization-if');
    }

    /**
     * Compile the else-can statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElsecan($expression)
    {
        if (! config('blade-hints.authorization_directives')) {
            return $this->originalCompileElsecan($expression);
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL .
            $this->originalCompileElsecan($expression) . PHP_EOL .
            $this->openBladeHintsWrapper("elsecan{$expression}", 'authorization-else');
    }

    /**
     * Compile the else-cannot statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElsecannot($expression)
    {
        if (! config('blade-hints.authorization_directives')) {
            return $this->originalCompileElsecannot($expression);
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileElsecannot($expression) . PHP_EOL
            . $this->openBladeHintsWrapper("elsecannot{$expression}", 'authorization-else');
    }

    /**
     * Compile the else-canany statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElsecanany($expression)
    {
        if (! config('blade-hints.authorization_directives')) {
            return $this->originalCompileElsecanany($expression);
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileElsecanany($expression) . PHP_EOL
            . $this->openBladeHintsWrapper("elsecanany{$expression}", 'authorization-else');
    }

    /**
     * Compile the end-can statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndcan()
    {
        if (! config('blade-hints.authorization_directives')) {
            return $this->originalCompileEndcan();
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileEndcan();
    }

    /**
     * Compile the end-cannot statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndcannot()
    {
        if (! config('blade-hints.authorization_directives')) {
            return $this->originalCompileEndcannot();
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileEndcannot();
    }

    /**
     * Compile the end-canany statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndcanany()
    {
        if (! config('blade-hints.authorization_directives')) {
            return $this->originalCompileEndcanany();
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileEndcanany();
    }
}
