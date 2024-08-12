<?php

test('cannot statements are compiled', function () {
    $string = <<< 'BLADE'
    @cannot('update', [$post])
    breeze
    @elsecannot('delete', [$post])
    sneeze
    @endcannot
    BLADE;

    $expected = <<< 'HTML'
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('update', [$post])): ?>
    <span class="blade-hints blade-hints__authorization-if" data-blade-hints-label="cannot(update, [$post])">
    breeze
    </span>
    <?php elseif (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('delete', [$post])): ?>
    <span class="blade-hints blade-hints__authorization-else" data-blade-hints-label="elsecannot(delete, [$post])">
    sneeze
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-blade-hints')
        ->toBe($expected);
});

test('cannot statement falls back to original when feature disabled', function () {

    config([
        'blade-hints.authorization_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @cannot ('update', [$post])
    breeze
    @elsecannot('delete', [$post])
    sneeze
    @endcannot
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-blade-hints');
});
