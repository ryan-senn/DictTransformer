<?php

namespace Test\Entities;

class Tile
{

    /**
     * @var mixed
     */
    private $id;

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var array
     */
    private $fields;

    /**
     * @param mixed $id
     * @param int   $x
     * @param int   $y
     * @param array $fields
     */
    public function __construct($id, int $x, int $y, $fields = [])
    {
        $this->id = $id;
        $this->x = $x;
        $this->y = $y;
        $this->fields = $fields;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getX() : int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY() : int
    {
        return $this->y;
    }

    /**
     * @return array
     */
    public function getFields() : array
    {
        return $this->fields;
    }
}