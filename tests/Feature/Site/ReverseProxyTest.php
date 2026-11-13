<?php

test('requests forwarded by a proxy keep the visitor IP and generate https links', function () {
    $this->withServerVariables(['REMOTE_ADDR' => '172.18.0.1'])
        ->withHeaders(['X-Forwarded-For' => '41.202.219.10', 'X-Forwarded-Proto' => 'https'])
        ->get('/')
        ->assertOk()
        ->assertSee('href="https://', false)
        ->assertDontSee('href="http://', false);

    expect(request()->ip())->toBe('41.202.219.10')
        ->and(request()->isSecure())->toBeTrue();
});
