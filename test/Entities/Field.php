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
     * Field constructor.
     *
     * @param                 $id
     * @param int             $level
     * @param Settlement|null $settlement
     */
    public function __construct($id, int $level, Settlement $settlement = null)
    {
        $this->id = $id;
        $this->level = $level;
        $this->settlement = $settlement;
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
}