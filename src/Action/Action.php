<?php
declare(strict_types=1);

namespace TeBo\Action;

abstract class Action implements ActionInterface
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
