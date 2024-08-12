<?php

test('canany statements are compiled', function () {
    $string = <<< 'BLADE'
    @canany (['create', 'update'], [$post])
    breeze
    @elsecanany(['delete', 'approve'], [$post])
    sneeze
    @endcan
    BLADE;

    $expected = <<< 'HTML'
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['create', 'update'], [$post])): ?>
    <span class="blade-hints blade-hints__authorization-if" data-blade-hints-label="canany([create, update], [$post])">
    breeze
    </span>
    <?php elseif (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['delete', 'approve'], [$post])): ?>
    <span class="blade-hints blade-hints__authorization-else" data-blade-hints-label="elsecanany([delete, approve], [$post])">
    sneeze
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-blade-hints')
        ->toBe($expected);
});

test('canany statement falls back to original when feature disabled', function () {

    config([
        'blade-hints.authorization_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @canany (['create', 'update'], [$post])
    breeze
    @elsecanany(['delete', 'approve'], [$post])
    sneeze
    @endcan
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-blade-hints');
});
