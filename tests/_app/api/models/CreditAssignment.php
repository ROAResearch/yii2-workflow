<?php

namespace app\api\models;

use tecnocen\roa\behaviors\Slug;
use yii\web\Linkable;
use yii\web\NotFoundHttpException;

/**
 * ROA contract to handle credit_worklog records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class CreditAssignment extends \app\models\CreditAssignment implements Linkable
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => Slug::class,
                'resourceName' => 'assignment',
                'parentSlugRelation' => 'process',
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return $this->getSlugLinks();
    }
}
