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
     * @param array $entities
     * @param mixed $transformer
     */
    public function __construct(array $entities, $transformer)
    {
        $this->entities = $entities;
        $this->transformer = $transformer;
    }

    /**
     * @return array
     */
    public function getEntities() : array
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