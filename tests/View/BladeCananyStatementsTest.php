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
    <span class="glimpse glimpse__authorization-if" data-glimpse-label="canany(['create', 'update'], [$post])">
    breeze
    </span>
    <?php elseif (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['delete', 'approve'], [$post])): ?>
    <span class="glimpse glimpse__authorization-else" data-glimpse-label="elsecanany(['delete', 'approve'], [$post])">
    sneeze
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-glimpse')
        ->toBe($expected);
});

test('canany statement falls back to original when feature disabled', function () {

    config([
        'glimpse.authorization_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @canany (['create', 'update'], [$post])
    breeze
    @elsecanany(['delete', 'approve'], [$post])
    sneeze
    @endcan
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-glimpse');
});
