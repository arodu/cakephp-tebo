<?php
declare(strict_types=1);

namespace TeBo\Action;

abstract class Action implements ActionInterface
{
    /**
     * Action constructor.
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Initialize the action.
     */
    public function initialize()
    {
        // This method is called after the constructor
    }

    /**
     * The command description for the help command.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return null;
    }
}
