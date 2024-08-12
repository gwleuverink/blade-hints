<?php

test('environment statements are compiled', function () {
    $string = <<< 'BLADE'
    @env('staging')
    breeze
    @else
    boom
    @endenv
    BLADE;

    $expected = <<< 'HTML'
    <?php if(app()->environment('staging')): ?>
    <span class="blade-hints blade-hints__environment-if" data-blade-hints-label="env(staging)">
    breeze
    <?php else: ?>
    boom
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-blade-hints')
        ->toBe($expected);
});

test('environment statements with multiple string parameters are compiled', function () {
    $string = <<< 'BLADE'
    @env('staging', 'production')
    breeze
    @else
    boom
    @endenv
    BLADE;

    $expected = <<< 'HTML'
    <?php if(app()->environment('staging', 'production')): ?>
    <span class="blade-hints blade-hints__environment-if" data-blade-hints-label="env(staging, production)">
    breeze
    <?php else: ?>
    boom
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-blade-hints')
        ->toBe($expected);
});

test('environment statements with array parameters are compiled', function () {
    $string = <<< 'BLADE'
    @env(['staging', 'production'])
    breeze
    @else
    boom
    @endenv
    BLADE;

    $expected = <<< 'HTML'
    <?php if(app()->environment(['staging', 'production'])): ?>
    <span class="blade-hints blade-hints__environment-if" data-blade-hints-label="env([staging, production])">
    breeze
    <?php else: ?>
    boom
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-blade-hints')
        ->toBe($expected);
});

test('production statements are compiled', function () {
    $string = <<< 'BLADE'
    @production
    breeze
    @else
    boom
    @endproduction
    BLADE;

    $expected = <<< 'HTML'
    <?php if(app()->environment('production')): ?>
    <span class="blade-hints blade-hints__environment-if" data-blade-hints-label="production">
    breeze
    <?php else: ?>
    boom
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-blade-hints')
        ->toBe($expected);
});

test('environment statement falls back to original when feature disabled', function () {

    config([
        'blade-hints.environment_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @env('staging')
    breeze
    @else
    boom
    @endenv
    @production
    foos
    @endproduction
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-blade-hints');
});
