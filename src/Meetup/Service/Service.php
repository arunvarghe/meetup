<?php
declare(strict_types=1);

namespace Meetup\Service;

use Meetup\Client\ClientInterface;

class Service implements ServiceInterface
{
    private ClientInterface $meetupClient;

    public function __construct(
        ClientInterface  $meetupClient
    ) {
        $this->meetupClient = $meetupClient;
    }

    public function get(): array
    {
        $response = $this->meetupClient->request('GET', '/todos/1');

        return json_decode($response->getContent(false), true);
    }
}