<?php

namespace DictTransformer;

class Collection
{

    /**
     * @var array
     */
    private $entities;

    /**
     * @var mixed
     */
    private $transformer;

    /**
     * @param mixed $entities
     * @param mixed $transformer
     */
    public function __construct($entities, $transformer)
    {
        $this->entities = $entities;
        $this->transformer = $transformer;
    }

    /**
     * @return mixed
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}