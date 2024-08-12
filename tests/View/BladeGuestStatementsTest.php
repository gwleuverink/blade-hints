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
    <span class="glimpse glimpse__guest-if" data-glimpse-label="guest(api)">
    breeze
    </span>
    <?php elseif(auth()->guard("standard")->guest()): ?>
    <span class="glimpse glimpse__guest-else" data-glimpse-label="else-guest(standard)">
    wheeze
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-glimpse')
        ->toBe($expected);
});

test('guest statement falls back to original when feature disabled', function () {

    config([
        'glimpse.guest_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @guest("api")
    breeze
    @elseguest("standard")
    wheeze
    @endguest
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-glimpse');
});
