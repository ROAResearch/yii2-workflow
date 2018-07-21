<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\behaviors\Curies;
use tecnocen\roa\behaviors\Slug;
use tecnocen\roa\hal\Embeddable;
use tecnocen\roa\hal\EmbeddableTrait;
use tecnocen\workflow\models as base;
use yii\web\Linkable;

/**
 * ROA contract to handle workflow stage records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Stage extends base\Stage implements Linkable, Embeddable
{
    use EmbeddableTrait {
        EmbeddableTrait::toArray as embedArray;
    }

    /**
     * @inheritdoc
     */
    public function toArray(
        array $fields = [],
        array $expand = [],
        $recursive = true
    ) {
        return $this->embedArray(
            $fields ?: $this->attributes(),
            $expand,
            $recursive
        );
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge($this->attributes(), ['totalTransitions']);
    }

    /**
     * @inheritdoc
     */
    protected $workflowClass = Workflow::class;

    /**
     * @inheritdoc
     */
    protected $transitionClass = Transition::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => Slug::class,
                'resourceName' => 'stage',
                'parentSlugRelation' => 'workflow',
            ],
            'curies' => Curies::class,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), $this->getCuriesLinks(), [
            'transitions' => $this->getSelfLink() . '/transition',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'workflow',
            'transitions',
            'detailTransitions',
            'totalTransitions',
        ];
    }
}
