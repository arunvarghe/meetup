<?php
declare(strict_types=1);

namespace Meetup\Tests\Unit\Client;

use Meetup\Client\Client;
use Meetup\Exception\ApiClientTransportException;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTest extends TestCase
{
    private ScopingHttpClient $httpClient;

    private Client $apiClient;

    public function setUp(): void
    {
        $this->httpClient = m::mock(ScopingHttpClient::class);
        $this->apiClient = new Client($this->httpClient, '60');
    }

    /**
     * @dataProvider getDataProviderForRequest
     */
    public function testRequest(string $requestMethod)
    {
        $this->httpClient->shouldreceive('request')
            ->once()
            ->andReturn($response = m::mock(ResponseInterface::class));

        $responseReturned = $this->apiClient->request($requestMethod, 'profile');

        $this->assertEquals($response, $responseReturned);
    }

    /**
     * @dataProvider getDataProviderForRequest
     */
    public function testRequestWithTransportException(string $requestMethod)
    {
        $this->httpClient->shouldreceive('request')
            ->once()
            ->andThrow(
                new TransportException()
            );

        $this->expectException(ApiClientTransportException::class);
        $this->expectExceptionCode(Response::HTTP_GATEWAY_TIMEOUT);
        $this->expectExceptionMessage(ApiClientTransportException::DEFAULT_MESSAGE);

        $this->apiClient->request($requestMethod, 'profile');
    }

    public function getDataProviderForRequest(): array
    {
        return [
            [Request::METHOD_GET],
            [Request::METHOD_POST],
            [Request::METHOD_PUT],
            [Request::METHOD_DELETE]
        ];
    }
}
