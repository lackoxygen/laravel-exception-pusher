<?php

require_once './vendor/autoload.php';

$ding = new \Lackoxygen\ExceptionPush\Agents\Ding();

$ding->token = '301534658d1d1deb6b8d9c43867ab85ca97b0a806ccf72164a7c214875c22e7e';

$ding->secret = 'SECc38ee72f38a796bae5b84b07cc3c0dbd8fd55e0f107f326f1d36ae6dd249b320';

$ding->report(
    ['hello world']
);
