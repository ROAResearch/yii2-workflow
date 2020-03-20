<?php

namespace app\api\modules;

use app\api\resources\{
    CreditResource,
    CreditWorkLogResource,
    CreditAssignmentResource
};

class Version extends \roaresearch\yii2\roa\modules\ApiVersion
{
    public const CREDIT_ROUTE = 'credit';
    public const WORKLOG_ROUTE = self::CREDIT_ROUTE
        . '/<process_id:\d+>/worklog';
    public const ASSIGNMENT_ROUTE = self::CREDIT_ROUTE
        . '/<process_id:\d+>/assignment';

    /**
     * @inheritdoc
     */
    public $resources = [
        self::CREDIT_ROUTE => ['class' => CreditResource::class],
        self::WORKLOG_ROUTE => ['class' => CreditWorkLogResource::class],
        self::ASSIGNMENT_ROUTE => ['class' => CreditAssignmentResource::class],
    ];
}
