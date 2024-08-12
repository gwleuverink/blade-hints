<?php

namespace Leuverink\Glimpse\View;

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

    abstract private function openGlimpseWrapper(string $label): string;

    abstract private function closeGlimpseWrapper(): string;

    /**
     * Compile the can statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileCan($expression)
    {
        if (! config('glimpse.authorization_directives')) {
            return $this->originalCompileCan($expression);
        }

        return $this->originalCompileCan($expression) . PHP_EOL .
            $this->openGlimpseWrapper("can{$expression}", 'authorization-if');
    }

    /**
     * Compile the cannot statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileCannot($expression)
    {
        if (! config('glimpse.authorization_directives')) {
            return $this->originalCompileCannot($expression);
        }

        return $this->originalCompileCannot($expression) . PHP_EOL
            . $this->openGlimpseWrapper("cannot{$expression}", 'authorization-if');
    }

    /**
     * Compile the canany statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileCanany($expression)
    {
        if (! config('glimpse.authorization_directives')) {
            return $this->originalCompileCanany($expression);
        }

        return $this->originalCompileCanany($expression) . PHP_EOL
            . $this->openGlimpseWrapper("canany{$expression}", 'authorization-if');
    }

    /**
     * Compile the else-can statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElsecan($expression)
    {
        if (! config('glimpse.authorization_directives')) {
            return $this->originalCompileElsecan($expression);
        }

        return $this->closeGlimpseWrapper() . PHP_EOL .
            $this->originalCompileElsecan($expression) . PHP_EOL .
            $this->openGlimpseWrapper("elsecan{$expression}", 'authorization-else');
    }

    /**
     * Compile the else-cannot statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElsecannot($expression)
    {
        if (! config('glimpse.authorization_directives')) {
            return $this->originalCompileElsecannot($expression);
        }

        return $this->closeGlimpseWrapper() . PHP_EOL
            . $this->originalCompileElsecannot($expression) . PHP_EOL
            . $this->openGlimpseWrapper("elsecannot{$expression}", 'authorization-else');
    }

    /**
     * Compile the else-canany statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElsecanany($expression)
    {
        if (! config('glimpse.authorization_directives')) {
            return $this->originalCompileElsecanany($expression);
        }

        return $this->closeGlimpseWrapper() . PHP_EOL
            . $this->originalCompileElsecanany($expression) . PHP_EOL
            . $this->openGlimpseWrapper("elsecanany{$expression}", 'authorization-else');
    }

    /**
     * Compile the end-can statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndcan()
    {
        if (! config('glimpse.authorization_directives')) {
            return $this->originalCompileEndcan();
        }

        return $this->closeGlimpseWrapper() . PHP_EOL
            . $this->originalCompileEndcan();
    }

    /**
     * Compile the end-cannot statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndcannot()
    {
        if (! config('glimpse.authorization_directives')) {
            return $this->originalCompileEndcannot();
        }

        return $this->closeGlimpseWrapper() . PHP_EOL
            . $this->originalCompileEndcannot();
    }

    /**
     * Compile the end-canany statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndcanany()
    {
        if (! config('glimpse.authorization_directives')) {
            return $this->originalCompileEndcanany();
        }

        return $this->closeGlimpseWrapper() . PHP_EOL
            . $this->originalCompileEndcanany();
    }
}
