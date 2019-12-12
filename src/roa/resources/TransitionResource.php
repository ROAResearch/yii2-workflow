<?php

namespace roaresearch\yii2\workflow\roa\resources;

use roaresearch\yii2\roa\controllers\Resource;
use roaresearch\yii2\workflow\roa\models\{Transition, TransitionSearch};

/**
 * Resource to handle `Transition` records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class TransitionResource extends Resource
{
    /**
     * @inhertidoc
     */
    public $modelClass = Transition::class;

    /**
     * @inhertidoc
     */
    public $searchClass = TransitionSearch::class;

    /**
     * @inheritdoc
     */
    public $idAttribute = 'target_stage_id';

    /**
     * @inheritdoc
     */
    public $filterParams = ['source_stage_id'];

    /**
     * @inheritdoc
     */
    public $createScenario = Transition::SCENARIO_CREATE;

    /**
     * @inheritdoc
     */
    public $updateScenario = Transition::SCENARIO_UPDATE;
}
