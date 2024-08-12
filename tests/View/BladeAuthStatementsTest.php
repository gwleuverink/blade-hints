<?php

test('auth statements are compiled', function () {
    $string = <<< 'BLADE'
    @auth("api")
    breeze
    @elseauth("standard")
    sneeze
    @endauth
    BLADE;

    $expected = <<< 'HTML'
    <?php if(auth()->guard("api")->check()): ?>
    <span class="glimpse glimpse__authentication-if" data-glimpse-label="auth(api)">
    breeze
    </span>
    <?php elseif(auth()->guard("standard")->check()): ?>
    <span class="glimpse glimpse__authentication-else" data-glimpse-label="elseauth(standard)">
    sneeze
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-glimpse')
        ->toBe($expected);
});

test('can statement falls back to original when feature disabled', function () {

    config([
        'glimpse.authentication_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @auth("api")
    breeze
    @endauth
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-glimpse');
});
