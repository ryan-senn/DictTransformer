<?php

namespace DictTransformer;

class NullableItem
{
    /**
     * @var mixed
     */
    private $entity;

    /**
     * @var mixed
     */
    private $transformer;

    /**
     * @param mixed $entity
     * @param mixed $transformer
     */
    public function __construct($entity, $transformer)
    {
        $this->entity = $entity;
        $this->transformer = $transformer;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}