<?php
declare(strict_types=1);

namespace Meetup\Exception;

use Symfony\Component\HttpFoundation\Response;


abstract class ApplicationException extends \Exception
{
    public function __construct(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
