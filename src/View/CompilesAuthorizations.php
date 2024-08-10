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
        return $this->originalCompileCan($expression) . $this->openGlimpseWrapper("can{$expression}", 'authorization-if');
    }

    /**
     * Compile the cannot statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileCannot($expression)
    {
        return $this->originalCompileCannot($expression) . $this->openGlimpseWrapper("cannot{$expression}", 'authorization-if');
    }

    /**
     * Compile the canany statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileCanany($expression)
    {
        return $this->originalCompileCanany($expression) . $this->openGlimpseWrapper("canany{$expression}", 'authorization-if');
    }

    /**
     * Compile the else-can statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElsecan($expression)
    {
        return $this->closeGlimpseWrapper() . $this->originalCompileElseCan($expression) . $this->openGlimpseWrapper("elsecan{$expression}", 'authorization-else');
    }

    /**
     * Compile the else-cannot statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElsecannot($expression)
    {
        return $this->closeGlimpseWrapper() . $this->originalCompileElseCannot($expression) . $this->openGlimpseWrapper("elsecannot{$expression}", 'authorization-else');
    }

    /**
     * Compile the else-canany statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileElsecanany($expression)
    {
        return $this->closeGlimpseWrapper() . $this->originalCompileElseCanany($expression) . $this->openGlimpseWrapper("elsecanany{$expression}", 'authorization-else');
    }

    /**
     * Compile the end-can statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndcan()
    {
        return $this->closeGlimpseWrapper() . $this->originalCompileEndcan();
    }

    /**
     * Compile the end-cannot statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndcannot()
    {
        return $this->closeGlimpseWrapper() . $this->originalCompileEndcannot();
    }

    /**
     * Compile the end-canany statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndcanany()
    {
        return $this->closeGlimpseWrapper() . $this->originalCompileEndcanany();
    }
}
