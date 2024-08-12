<?php

test('can statements are compiled', function () {
    $string = <<< 'BLADE'
    @can('update', [$post])
    breeze
    @elsecan('delete', [$post])
    sneeze
    @endcan
    BLADE;

    $expected = <<< 'HTML'
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', [$post])): ?>
    <span class="glimpse glimpse__authorization-if" data-glimpse-label="can(update, [$post])">
    breeze
    </span>
    <?php elseif (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', [$post])): ?>
    <span class="glimpse glimpse__authorization-else" data-glimpse-label="elsecan(delete, [$post])">
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
        'glimpse.authorization_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @can('update', [{$post}])
    @elsecan('delete', [{$post}])
    @endcan
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-glimpse');
});
