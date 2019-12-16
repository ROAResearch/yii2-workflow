<?php

namespace app\fixtures;

use roaresearch\yii2\workflow\models\Workflow;
use yii\test\ActiveFixture;

/**
 * Fixture to load default workflow.
 *
 * @author Carlos (neverabe) Llamosas <carlos@invernaderolabs.com>
 */
class WorkflowFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = Workflow::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/workflow.php';
}
