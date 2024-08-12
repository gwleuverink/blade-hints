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
    <span class="glimpse glimpse__authorization-if" data-glimpse-label="cannot('update', [$post])">
    breeze
    </span>
    <?php elseif (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('delete', [$post])): ?>
    <span class="glimpse glimpse__authorization-else" data-glimpse-label="elsecannot('delete', [$post])">
    sneeze
    </span>
    <?php endif; ?>
    HTML;

    expect($this->compiler->compileString($string))
        ->toContain('data-glimpse')
        ->toBe($expected);
});

test('cannot statement falls back to original when feature disabled', function () {

    config([
        'glimpse.authorization_directives' => false,
    ]);

    $string = <<< 'BLADE'
    @cannot ('update', [$post])
    breeze
    @elsecannot('delete', [$post])
    sneeze
    @endcannot
    BLADE;

    expect($this->compiler->compileString($string))
        ->not->toContain('data-glimpse');
});
