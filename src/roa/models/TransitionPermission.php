<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\roa\hal\{Contract, ContractTrait};
use roaresearch\yii2\workflow\models as base;

/**
 * ROA contract to handle workflow transition permissions records.
 */
class TransitionPermission extends base\TransitionPermission implements Contract
{
    use ContractTrait;

    /**
     * @inheritdoc
     */
    protected $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    protected $transitionClass = Transition::class;

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): array
    {
        return [
            'idAttribute' => 'permission',
            'resourceName' => 'permission',
            'parentSlugRelation' => 'transition',
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['sourceStage', 'targetStage', 'transition'];
    }
}
