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
    <span class="blade-hints blade-hints__authentication-if" data-blade-hints-label="auth(api)">
    breeze
    </span>
    <?php elseif(auth()->guard("standard")->check()): ?>
    <span class="blade-hints blade-hints__authentication-else" data-blade-hints-label="elseauth(standard)">
    sneeze
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-blade-hints')
        ->toBe($expected);
});

test('can statement falls back to original when feature disabled', function () {

    config([
        'blade-hints.authentication_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @auth("api")
    breeze
    @endauth
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-blade-hints');
});
