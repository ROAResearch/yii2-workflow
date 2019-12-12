<?php

namespace app\fixtures;

use roaresearch\yii2\workflow\models\Stage;
use yii\test\ActiveFixture;

/**
 * Fixture to load default stage.
 *
 * @author Angel (Faryshta) Guevara <aguevara@invernaderolabs.com>
 */
class AuthItemFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->tableName = \Yii::$app->authManager->itemTable;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/auth_item.php';
}
