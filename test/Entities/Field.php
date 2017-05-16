<?php

namespace Test\Entities;

class Field
{

    /**
     * @var mixed
     */
    private $id;

    /**
     * @var int
     */
    private $level;

    /**
     * @var Settlement|null
     */
    private $settlement;

    /**
     * @var Settlement2|null
     */
    private $settlement2;

    /**
     * Field constructor.
     *
     * @param                  $id
     * @param int              $level
     * @param Settlement|null  $settlement
     * @param Settlement2|null $settlement2
     */
    public function __construct($id, int $level, Settlement $settlement = null, Settlement2 $settlement2 = null)
    {
        $this->id = $id;
        $this->level = $level;
        $this->settlement = $settlement;
        $this->settlement2 = $settlement2;
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
    public function getLevel() : int
    {
        return $this->level;
    }

    /**
     * @return Settlement|null
     */
    public function getSettlement()
    {
        return $this->settlement;
    }

    /**
     * @return null|Settlement2
     */
    public function getSettlement2()
    {
        return $this->settlement2;
    }
}