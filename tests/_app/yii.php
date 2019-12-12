#!/usr/bin/env php
<?php

require dirname(__DIR__) . '/_bootstrap.php';
require __DIR__ . '/constants.php';

$config = require __DIR__ . '/config/console.php';

$exitCode = (new yii\console\Application($config))->run();
exit($exitCode);
