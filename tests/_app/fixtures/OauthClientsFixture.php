<?php

namespace app\fixtures;

use roaresearch\yii2\oauth2server\models\OauthClients;

/**
 * Fixture to load default clients.
 */
class OauthClientsFixture extends \yii\test\ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = OauthClients::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/clients.php';
}
