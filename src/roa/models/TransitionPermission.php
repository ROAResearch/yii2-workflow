<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\roa\hal\{ARContract, ContractTrait};
use roaresearch\yii2\workflow\models as base;

/**
 * ROA contract to handle workflow transition permissions records.
 */
class TransitionPermission extends base\TransitionPermission implements
    ARContract
{
    use ContractTrait;

    /**
     * @inheritdoc
     */
    protected string $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    protected string $transitionClass = Transition::class;

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): array
    {
        return [
            'idAttributes' => ['permission'],
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
