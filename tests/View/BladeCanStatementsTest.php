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
    <span class="blade-hints blade-hints__authorization-if" data-blade-hints-label="can(update, [$post])">
    breeze
    </span>
    <?php elseif (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', [$post])): ?>
    <span class="blade-hints blade-hints__authorization-else" data-blade-hints-label="elsecan(delete, [$post])">
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
        'blade-hints.authorization_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @can('update', [{$post}])
    @elsecan('delete', [{$post}])
    @endcan
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-blade-hints');
});
