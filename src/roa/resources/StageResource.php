<?php

namespace roaresearch\yii2\workflow\roa\resources;

use roaresearch\yii2\roa\controllers\Resource;
use roaresearch\yii2\workflow\roa\models\{Stage, StageSearch};

/**
 * Resource to handle `Stage` records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class StageResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = Stage::class;

    /**
     * @inheritdoc
     */
    public $searchClass = StageSearch::class;

    /**
     * @inheritdoc
     */
    public $filterParams = ['workflow_id'];
}
