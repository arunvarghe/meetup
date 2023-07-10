<?php
declare(strict_types=1);

namespace Meetup\Tests\Unit\Service;

use Meetup\Client\ClientInterface;
use Meetup\Service\Service;
use Meetup\Service\ServiceInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ServiceTest extends TestCase
{
    private ServiceInterface $service;

    private ClientInterface $meetupClient;

    public function setUp(): void
    {
        $this->meetupClient = m::mock(ClientInterface::class);
        $this->service = new Service(
            $this->meetupClient
        );
    }

    public function testGet()
    {
        $this->meetupClient->shouldReceive('request')
            ->once()
            ->with('GET', '/todos/1')
            ->andReturn(
                $response = m::mock(ResponseInterface::class)
            );

        $response->shouldReceive('getContent')
            ->once()
            ->with(false)
            ->andReturn(
                $content = '{"content":"sample"}'
            );

        $result = $this->service->get();

        $this->assertEquals($result, json_decode($content, true));
    }
}
