<?php
declare(strict_types=1);

namespace TeBo\Exception;

use Cake\Http\Exception\NotFoundException;
use Throwable;

class ActionNotFoundException extends NotFoundException
{
    /**
     * @inheritDoc
     */
    protected int $_defaultCode = 404;

    /**
     * Constructor
     *
     * @param string|null $message If no message is given 'Not Found' will be the message
     * @param int|null $code Status code, defaults to 404
     * @param \Throwable|null $previous The previous exception.
     */
    public function __construct(?string $message = null, ?int $code = null, ?Throwable $previous = null)
    {
        if (!$message) {
            $message = 'Action Not Found';
        }
        parent::__construct($message, $code, $previous);
    }
}
