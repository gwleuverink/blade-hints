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
    <span class="glimpse glimpse__environment-if" data-glimpse-label="env(staging)">
    breeze
    <?php else: ?>
    boom
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-glimpse')
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
    <span class="glimpse glimpse__environment-if" data-glimpse-label="env(staging, production)">
    breeze
    <?php else: ?>
    boom
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-glimpse')
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
    <span class="glimpse glimpse__environment-if" data-glimpse-label="env([staging, production])">
    breeze
    <?php else: ?>
    boom
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-glimpse')
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
    <span class="glimpse glimpse__environment-if" data-glimpse-label="production">
    breeze
    <?php else: ?>
    boom
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-glimpse')
        ->toBe($expected);
});

test('environment statement falls back to original when feature disabled', function () {

    config([
        'glimpse.environment_directives' => false,
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
        ->not->toContain('data-glimpse');
});
