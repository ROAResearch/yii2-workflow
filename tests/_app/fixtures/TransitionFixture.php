<?php

namespace app\fixtures;

use roaresearch\yii2\workflow\models\Transition;
use yii\test\ActiveFixture;

/**
 * Fixture to load default transition.
 *
 * @author Carlos (neverabe) Llamosas <carlos@invernaderolabs.com>
 */
class TransitionFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = Transition::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/transition.php';

    /**
     * @inheritdoc
     */
    public $depends = ['app\fixtures\StageFixture'];
}
