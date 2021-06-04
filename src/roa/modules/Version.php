<?php

namespace roaresearch\yii2\workflow\roa\modules;

use roaresearch\yii2\workflow\roa\resources\{
    PermissionResource,
    StageResource,
    TransitionResource,
    WorkflowResource
};

class Version extends \roaresearch\yii2\roa\modules\ApiVersion
{
    public const WORKFLOW_ROUTE = 'workflow';
    public const STAGE_ROUTE = self::WORKFLOW_ROUTE
        . '/<workflow_id:\d+>/stage';
    public const TRANSITION_ROUTE = self::STAGE_ROUTE
        . '/<source_stage_id:\d+>/transition';
    public const PERMISSION_ROUTE = self::TRANSITION_ROUTE
        . '/<target_stage_id:\d+>/permission';

    /**
     * @inheritdoc
     */
    public array $resources = [
        self::WORKFLOW_ROUTE => ['class' => WorkflowResource::class],
        self::STAGE_ROUTE => ['class' => StageResource::class],
        self::TRANSITION_ROUTE => ['class' => TransitionResource::class],
        self::PERMISSION_ROUTE => [
            'class' => PermissionResource::class,
            'urlRule' => ['tokens' => ['{id}' => '<id:\w+>']],
        ],
    ];
}
