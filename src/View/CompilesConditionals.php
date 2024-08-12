<?php

namespace Leuverink\BladeHints\View;

use Illuminate\View\Compilers\Concerns\CompilesConditionals as Original;

trait CompilesConditionals
{
    use Original {
        Original::compileAuth as originalCompileAuth;
        Original::compileElseAuth as originalCompileElseAuth;
        Original::compileEndAuth as originalCompileEndAuth;

        Original::compileEnv as originalCompileEnv;
        Original::compileEndEnv as originalCompileEndEnv;
        Original::compileProduction as originalCompileProduction;
        Original::compileEndProduction as originalCompileEndProduction;

        Original::compileGuest as originalCompileGuest;
        Original::compileElseGuest as originalCompileElseGuest;
        Original::compileEndGuest as originalCompileEndGuest;
    }

    abstract private function openBladeHintsWrapper(string $label): string;

    abstract private function closeBladeHintsWrapper(): string;

    /**
     * Compile the if-auth statements into valid PHP.
     *
     * @param  string|null  $guard
     * @return string
     */
    protected function compileAuth($guard = null)
    {
        if (! config('blade-hints.authentication_directives')) {
            return $this->originalCompileAuth($guard);
        }

        $guard = is_null($guard) ? '()' : $guard;

        return $this->originalCompileAuth($guard) . PHP_EOL
            . $this->openBladeHintsWrapper("auth{$guard}", 'authentication-if');
    }

    /**
     * Compile the elseauth statements into valid PHP.
     *
     * @param  string|null  $guard
     * @return string
     */
    protected function compileElseAuth($guard = null)
    {
        if (! config('blade-hints.authentication_directives')) {
            return $this->originalCompileElseAuth($guard);
        }

        $guard = is_null($guard) ? '()' : $guard;

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileElseAuth($guard) . PHP_EOL
            . $this->openBladeHintsWrapper("elseauth{$guard}", 'authentication-else');
    }

    /**
     * Compile the end-auth statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndAuth()
    {
        if (! config('blade-hints.authentication_directives')) {
            return $this->originalCompileEndAuth();
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileEndAuth();
    }

    /**
     * Compile the env statements into valid PHP.
     *
     * @param  string  $environments
     * @return string
     */
    protected function compileEnv($environments)
    {
        if (! config('blade-hints.environment_directives')) {
            return $this->originalCompileEnv($environments);
        }

        return $this->originalCompileEnv($environments) . PHP_EOL
            . $this->openBladeHintsWrapper("env{$environments}", 'environment-if');
    }

    /**
     * Compile the end-env statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndEnv()
    {
        if (! config('blade-hints.environment_directives')) {
            return $this->originalCompileEndEnv();
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileEndEnv();
    }

    /**
     * Compile the production statements into valid PHP.
     *
     * @return string
     */
    protected function compileProduction()
    {
        if (! config('blade-hints.environment_directives')) {
            return $this->originalCompileProduction();
        }

        return $this->originalCompileProduction() . PHP_EOL
            . $this->openBladeHintsWrapper('production', 'environment-if');
    }

    /**
     * Compile the end-production statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndProduction()
    {
        if (! config('blade-hints.environment_directives')) {
            return $this->originalCompileEndProduction();
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileEndProduction();
    }

    /**
     * Compile the if-guest statements into valid PHP.
     *
     * @param  string|null  $guard
     * @return string
     */
    protected function compileGuest($guard = null)
    {
        if (! config('blade-hints.guest_directives')) {
            return $this->originalCompileGuest($guard);
        }

        $guard = is_null($guard) ? '()' : $guard;

        return $this->originalCompileGuest($guard) . PHP_EOL
            . $this->openBladeHintsWrapper("guest{$guard}", 'guest-if');
    }

    /**
     * Compile the else-guest statements into valid PHP.
     *
     * @param  string|null  $guard
     * @return string
     */
    protected function compileElseGuest($guard = null)
    {
        if (! config('blade-hints.guest_directives')) {
            return $this->originalCompileElseGuest($guard);
        }

        $guard = is_null($guard) ? '()' : $guard;

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileElseGuest($guard) . PHP_EOL
            . $this->openBladeHintsWrapper("else-guest{$guard}", 'guest-else');
    }

    /**
     * Compile the end-guest statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndGuest()
    {
        if (! config('blade-hints.guest_directives')) {
            return $this->originalCompileEndGuest();
        }

        return $this->closeBladeHintsWrapper() . PHP_EOL
            . $this->originalCompileEndGuest();
    }
}
