<?php

return [
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'aliases' => [
        '@tests' => dirname(dirname(__DIR__)),
        '@roaresearch/yii2/workflow' => dirname(dirname(dirname(__DIR__)))
            . '/src',
        '@roaresearch/yii2/oauth2server' => VENDOR_DIR
            . '/roaresearch/yii2-oauth2-server/src',
    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'authManager' => [
             'class' => yii\rbac\DbManager::class,
        ],
    ],
];
