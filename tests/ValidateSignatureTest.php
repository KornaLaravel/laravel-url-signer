<?php

namespace Spatie\UrlSigner\Laravel\Tests;

use Spatie\UrlSigner\Laravel\UrlSigner;
use Spatie\UrlSigner\Md5UrlSigner;
use Spatie\UrlSigner\UrlSigner as BaseUrlSigner;

it('registers an url signer', function() {
    $instance = app('url-signer');

    expect($instance)->toBeInstanceOf(Md5UrlSigner::class);
});

it('rejects an unsigned url', function() {
    $this
        ->get("{$this->hostName}/protected-route")
        ->assertForbidden();
});

it('accepts a signed url', function() {
    $url = app('url-signer')->sign("{$this->hostName}/protected-route", 1);

    $this->get($url)->assertSuccessful();
});

it('rejects a forged url', function() {

    $this->get("{$this->hostName}/protected-route?expires=123&signature=456")
        ->assertForbidden();
});
