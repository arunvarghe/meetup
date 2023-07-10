<?php
declare(strict_types=1);

namespace Meetup\Exception;

use Symfony\Component\HttpFoundation\Response;

class ApiClientTransportException extends ApplicationException
{
    const DEFAULT_MESSAGE = 'The server did not respond in time';

    /**
     * {@inheritDoc}
     */
    public function __construct(
        string $message = self::DEFAULT_MESSAGE,
        int $code = Response::HTTP_GATEWAY_TIMEOUT
    )
    {
        parent::__construct($message, $code);
    }
}
