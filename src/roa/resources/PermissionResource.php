<?php

namespace roaresearch\yii2\workflow\roa\resources;

use roaresearch\yii2\workflow\roa\models\{
    TransitionPermission,
    TransitionPermissionSearch
};
use roaresearch\yii2\roa\controllers\Resource;

/**
 * Resource to assign permissions to a transition.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class PermissionResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = TransitionPermission::class;

    /**
     * @inheritdoc
     */
    public ?string $searchClass = TransitionPermissionSearch::class;

    /**
     * @inheritdoc
     */
    public string $idAttribute = 'permission';

    /**
     * @inheritdoc
     */
    public $createScenario = TransitionPermission::SCENARIO_CREATE;

    /**
     * @inheritdoc
     */
    public $updateScenario = TransitionPermission::SCENARIO_UPDATE;

    /**
     * @inheritdoc
     */
    public array $filterParams = ['source_stage_id', 'target_stage_id'];
}
