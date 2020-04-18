<?php

namespace roaresearch\yii2\workflow\roa\resources;

use roaresearch\yii2\roa\{actions\SoftDelete, controllers\Resource};
use roaresearch\yii2\workflow\roa\models\{Stage, StageSearch};
use yii\db\ActiveQuery;

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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['delete']['class'] = SoftDelete::class;

        return $actions;
    }

    /**
     * @inheritdoc
     */
    public function baseQuery(): ActiveQuery
    {
        return parent::baseQuery()
            ->andWhere(['deleted_at' => null, 'deleted_by' => null]);
    }
}
