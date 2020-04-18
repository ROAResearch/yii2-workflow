<?php

namespace roaresearch\yii2\workflow\roa\resources;

use roaresearch\yii2\roa\{actions\SoftDelete, controllers\Resource};
use roaresearch\yii2\workflow\roa\models\{Workflow, WorkflowSearch};

/**
 * Resource to handle `Workflow` records
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class WorkflowResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = Workflow::class;

    /**
     * @inheritdoc
     */
    public $searchClass = WorkflowSearch::class;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['delete']['class'] = SoftDelete::class;

        return $actions;
    }
}
