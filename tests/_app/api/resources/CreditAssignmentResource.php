<?php

namespace app\api\resources;

use app\api\models\CreditAssignment;
use roaresearch\yii2\roa\controllers\Resource;

/**
 * CRUD resource for `Credit Assignment` records
 * @author Carlos (neverabe) Llamosas <carlos@invernaderolabs.com>
 */
class CreditAssignmentResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = CreditAssignment::class;
    /**
     * @inheritdoc
     */
    public array $filterParams = ['process_id'];
    /**
     * @inheritdoc
     */
    public string $idAttribute = 'user_id';
}
