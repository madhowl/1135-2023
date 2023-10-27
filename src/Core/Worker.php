<?php


namespace App\Core;


/**
 * Class Worker
 * @package App\Core
 */
class Worker
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Worker constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

}