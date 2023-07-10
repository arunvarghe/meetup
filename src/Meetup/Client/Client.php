<?php
declare(strict_types=1);

namespace Meetup\Client;

use Meetup\Exception\ApiClientTransportException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class Client implements ClientInterface
{
    private HttpClientInterface $httpClient;

    private ?string $timeout;

    public function __construct(
        HttpClientInterface $httpClient,
        string $timeout = null
    ) {
        $this->httpClient = $httpClient;
        $this->timeout = $timeout;
    }

    public function request(string $method, string $route, array $options = []): ResponseInterface
    {
        if ($this->timeout !== null ) {
            $options['timeout'] = $this->timeout;
        }

        try {
            return $this->httpClient->request($method, $route, $options);
        } catch (TransportExceptionInterface $exception) {
            throw new ApiClientTransportException();
        }
    }

}
