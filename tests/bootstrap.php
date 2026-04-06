<?php declare(strict_types=1);

require dirname(__DIR__, 3) . '/modules/Common/tests/Bootstrap.php';

\CommonTest\Bootstrap::bootstrap(
    [
        'Common',
        'Coins',
    ],
    'CoinsTest',
    __DIR__ . '/CoinsTest'
);
