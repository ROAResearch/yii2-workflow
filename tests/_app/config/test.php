<?php

use app\api\modules\Version as V1;
use roaresearch\yii2\workflow\roa\modules\Version as WorkflowVersion;
use roaresearch\yii2\roa\{
    controllers\ProfileResource,
    hal\JsonResponseFormatter
};
use yii\web\Response;

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common.php',
    [
        'id' => 'yii2-workflow-tests',
        'bootstrap' => ['api'],
        'modules' => [
            'api' => [
                'class' => roaresearch\yii2\roa\modules\ApiContainer::class,
                'identityClass' => app\models\User::class,
                'versions' => [
                    'w1' => [
                        'class' => WorkflowVersion::class,
                    ],
                    'v1' => [
                        'class' => V1::class,
                    ],
                ],
            ],
            'rmdb' => [
                'class' => roaresearch\yii2\rmdb\Module::class,
            ],
        ],
        'components' => [
            'mailer' => [
                'useFileTransport' => true,
            ],
            'user' => ['identityClass' => app\models\User::class],
            'urlManager' => [
                'showScriptName' => true,
                'enablePrettyUrl' => true,
            ],
            'request' => [
                'cookieValidationKey' => 'test',
                'enableCsrfValidation' => false,
            ],
        ],
        'params' => [],
    ]
);
