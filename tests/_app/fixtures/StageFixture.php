<?php

namespace app\fixtures;

use roaresearch\yii2\workflow\models\Stage;
use yii\test\ActiveFixture;

/**
 * Fixture to load default stage.
 *
 * @author Carlos (neverabe) Llamosas <carlos@invernaderolabs.com>
 */
class StageFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = Stage::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/stage.php';

    /**
     * @inheritdoc
     */
    public $depends = ['app\fixtures\WorkflowFixture'];
}
