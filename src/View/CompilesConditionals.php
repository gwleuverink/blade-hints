<?php

namespace Leuverink\Glimpse\View;

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

    abstract private function openGlimpseWrapper(string $label): string;

    abstract private function closeGlimpseWrapper(): string;

    /**
     * Compile the if-auth statements into valid PHP.
     *
     * @param  string|null  $guard
     * @return string
     */
    protected function compileAuth($guard = null)
    {
        if (! config('glimpse.authentication_directives')) {
            return $this->originalCompileAuth($guard);
        }

        $guard = is_null($guard) ? '()' : $guard;

        return "<?php if(auth()->guard{$guard}->check()): ?>";
    }

    /**
     * Compile the else-auth statements into valid PHP.
     *
     * @param  string|null  $guard
     * @return string
     */
    protected function compileElseAuth($guard = null)
    {
        if (! config('glimpse.authentication_directives')) {
            return $this->originalCompileElseAuth($guard);
        }

        $guard = is_null($guard) ? '()' : $guard;

        return "<?php elseif(auth()->guard{$guard}->check()): ?>";
    }

    /**
     * Compile the end-auth statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndAuth()
    {
        if (! config('glimpse.authentication_directives')) {
            return $this->originalCompileEndAuth();
        }

        return '<?php endif; ?>';
    }

    /**
     * Compile the env statements into valid PHP.
     *
     * @param  string  $environments
     * @return string
     */
    protected function compileEnv($environments)
    {
        if (! config('glimpse.environment_directives')) {
            return $this->originalCompileEnv($environments);
        }

        return "<?php if(app()->environment{$environments}): ?>";
    }

    /**
     * Compile the end-env statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndEnv()
    {
        if (! config('glimpse.environment_directives')) {
            return $this->originalCompileEndEnv();
        }

        return '<?php endif; ?>';
    }

    /**
     * Compile the production statements into valid PHP.
     *
     * @return string
     */
    protected function compileProduction()
    {
        if (! config('glimpse.environment_directives')) {
            return $this->originalCompileProduction();
        }

        return "<?php if(app()->environment('production')): ?>";
    }

    /**
     * Compile the end-production statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndProduction()
    {
        if (! config('glimpse.environment_directives')) {
            return $this->originalCompileEndProduction();
        }

        return '<?php endif; ?>';
    }

    /**
     * Compile the if-guest statements into valid PHP.
     *
     * @param  string|null  $guard
     * @return string
     */
    protected function compileGuest($guard = null)
    {
        if (! config('glimpse.guest_directives')) {
            return $this->originalCompileGuest($guard);
        }

        $guard = is_null($guard) ? '()' : $guard;

        return "<?php if(auth()->guard{$guard}->guest()): ?>";
    }

    /**
     * Compile the else-guest statements into valid PHP.
     *
     * @param  string|null  $guard
     * @return string
     */
    protected function compileElseGuest($guard = null)
    {
        if (! config('glimpse.guest_directives')) {
            return $this->originalCompileElseGuest($guard);
        }

        $guard = is_null($guard) ? '()' : $guard;

        return "<?php elseif(auth()->guard{$guard}->guest()): ?>";
    }

    /**
     * Compile the end-guest statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndGuest()
    {
        return '<?php endif; ?>';
    }
}
