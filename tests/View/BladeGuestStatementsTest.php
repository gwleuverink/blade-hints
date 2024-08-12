<?php

test('guest statements are compiled', function () {
    $string = <<< 'BLADE'
    @guest("api")
    breeze
    @elseguest("standard")
    wheeze
    @endguest
    BLADE;

    $expected = <<< 'HTML'
    <?php if(auth()->guard("api")->guest()): ?>
    <span class="blade-hints blade-hints__guest-if" data-blade-hints-label="guest(api)">
    breeze
    </span>
    <?php elseif(auth()->guard("standard")->guest()): ?>
    <span class="blade-hints blade-hints__guest-else" data-blade-hints-label="else-guest(standard)">
    wheeze
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-blade-hints')
        ->toBe($expected);
});

test('guest statement falls back to original when feature disabled', function () {

    config([
        'blade-hints.guest_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @guest("api")
    breeze
    @elseguest("standard")
    wheeze
    @endguest
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-blade-hints');
});
