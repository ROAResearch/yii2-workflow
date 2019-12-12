<?php

namespace app\fixtures;

use roaresearch\yii2\oauth2server\models\OauthAccessTokens;

class OauthAccessTokensFixture extends \yii\test\ActiveFixture
{
    public const SIMPLE_TOKEN = '1234567812345678123456781234567812345678';
    public $modelClass = OauthAccessTokens::class;
    public $dataFile = __DIR__ . '/data/access_tokens.php';
    public $depends = [UserFixture::class, OauthClientsFixture::class];
}
