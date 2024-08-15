<?php

namespace Tests;

use Mockery as m;
use Illuminate\Filesystem\Filesystem;
use Leuverink\BladeHints\View\BladeCompiler;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Illuminate\View\Compilers\CompilerInterface;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use WithWorkbench;

    protected CompilerInterface $compiler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->compiler = new BladeCompiler($this->getFiles(), __DIR__);
    }

    protected function getFiles()
    {
        return m::mock(Filesystem::class);
    }
}
