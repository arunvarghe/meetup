<?php
declare(strict_types=1);

namespace Meetup\Client;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ClientInterface
{
    public function request(string $method, string $route, array $options = []): ResponseInterface;
}
