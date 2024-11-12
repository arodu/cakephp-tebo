<?php
declare(strict_types=1);

namespace TeBo\TeBo;

abstract class TeBoCommand implements CommandInterface
{
    public function __construct()
    {
        $this->initialize();
    }

    public function initialize()
    {
        // This method is called after the constructor
    }
}
