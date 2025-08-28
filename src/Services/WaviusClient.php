<?php

namespace Wavius\WhatsApp\Services;

use Wavius\WhatsApp\Contracts\WaviusClientInterface;
use Wavius\WhatsApp\Config\WaviusConfig;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\PendingRequest;

/**
 * Wavius Client Implementation
 * 
 * HTTP client implementation for the Wavius API using Laravel's HTTP facade.
 * Handles all HTTP requests to the Wavius WhatsApp API.
 */
class WaviusClient implements WaviusClientInterface
{
    /**
     * Current authentication token
     */
    private ?string $token = null;

    /**
     * Current instance ID
     */
    private ?string $instanceId = null;

    /**
     * HTTP client instance
     */
    private PendingRequest $httpClient;

    /**
     * Constructor
     */
    public function __construct(WaviusConfig $config)
    {
        $this->httpClient = Http::timeout($config->getApiTimeout())
            ->retry($config->getApiRetryAttempts(), $config->getApiRetryDelay())
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'User-Agent' => 'Wavius-Laravel-SDK/1.0',
            ]);

        // Set base URL
        $this->httpClient->baseUrl($config->getApiBaseUrl() . '/' . $config->getApiVersion());
    }

    /**
     * Make a GET request to the Wavius API
     */
    public function get(string $endpoint, array $params = []): \Psr\Http\Message\ResponseInterface
    {
        $url = $this->buildUrl($endpoint);
        
        $request = $this->prepareRequest();
        
        $response = $request->get($url, $params);
        
        return $this->convertResponse($response);
    }

    /**
     * Make a POST request to the Wavius API
     */
    public function post(string $endpoint, array $data = []): \Psr\Http\Message\ResponseInterface
    {
        $url = $this->buildUrl($endpoint);
        
        $request = $this->prepareRequest();
        
        $response = $request->post($url, $data);
        
        return $this->convertResponse($response);
    }

    /**
     * Make a PUT request to the Wavius API
     */
    public function put(string $endpoint, array $data = []): \Psr\Http\Message\ResponseInterface
    {
        $url = $this->buildUrl($endpoint);
        
        $request = $this->prepareRequest();
        
        $response = $request->put($url, $data);
        
        return $this->convertResponse($response);
    }

    /**
     * Make a DELETE request to the Wavius API
     */
    public function delete(string $endpoint, array $params = []): \Psr\Http\Message\ResponseInterface
    {
        $url = $this->buildUrl($endpoint);
        
        $request = $this->prepareRequest();
        
        $response = $request->delete($url, $params);
        
        return $this->convertResponse($response);
    }

    /**
     * Upload a file to the Wavius API
     */
    public function upload(string $endpoint, string $filePath, array $data = []): \Psr\Http\Message\ResponseInterface
    {
        $url = $this->buildUrl($endpoint);
        
        $request = $this->prepareRequest();
        
        // Prepare multipart data
        $multipartData = [];
        
        // Add file
        if (file_exists($filePath)) {
            $multipartData[] = [
                'name' => 'file',
                'contents' => fopen($filePath, 'r'),
                'filename' => basename($filePath),
            ];
        }
        
        // Add other data
        foreach ($data as $key => $value) {
            $multipartData[] = [
                'name' => $key,
                'contents' => is_array($value) ? json_encode($value) : $value,
            ];
        }
        
        $response = $request->attach('file', file_get_contents($filePath), basename($filePath))
            ->post($url, $data);
        
        return $this->convertResponse($response);
    }

    /**
     * Set the authentication token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Get the current authentication token
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Set the instance ID for requests
     */
    public function setInstanceId(string $instanceId): void
    {
        $this->instanceId = $instanceId;
    }

    /**
     * Get the current instance ID
     */
    public function getInstanceId(): ?string
    {
        return $this->instanceId;
    }

    /**
     * Build the full URL for the request
     */
    private function buildUrl(string $endpoint): string
    {
        $url = $endpoint;
        
        // Add instance ID to URL if provided and not already in endpoint
        if ($this->instanceId && !str_contains($endpoint, '/instances/')) {
            $url = "/instances/{$this->instanceId}{$endpoint}";
        }
        
        return $url;
    }

    /**
     * Prepare the HTTP request with authentication
     */
    private function prepareRequest(): PendingRequest
    {
        $request = clone $this->httpClient;
        
        // Add authentication header if token is set
        if ($this->token) {
            $request->withHeaders([
                'Authorization' => "Bearer {$this->token}",
            ]);
        }
        
        return $request;
    }

    /**
     * Convert Laravel HTTP response to PSR-7 ResponseInterface
     */
    private function convertResponse(Response $response): \Psr\Http\Message\ResponseInterface
    {
        return new class($response) implements \Psr\Http\Message\ResponseInterface {
            private Response $response;
            
            public function __construct(Response $response)
            {
                $this->response = $response;
            }
            
            public function getStatusCode(): int
            {
                return $this->response->status();
            }
            
            public function getBody(): \Psr\Http\Message\StreamInterface
            {
                return new class($this->response->body()) implements \Psr\Http\Message\StreamInterface {
                    private string $content;
                    private int $position = 0;
                    
                    public function __construct(string $content)
                    {
                        $this->content = $content;
                    }
                    
                    public function read(int $length): string
                    {
                        $data = substr($this->content, $this->position, $length);
                        $this->position += $length;
                        return $data;
                    }
                    
                    public function write(string $string): int
                    {
                        $this->content .= $string;
                        return strlen($string);
                    }
                    
                    public function seek(int $offset, int $whence = SEEK_SET): bool
                    {
                        switch ($whence) {
                            case SEEK_SET:
                                $this->position = $offset;
                                break;
                            case SEEK_CUR:
                                $this->position += $offset;
                                break;
                            case SEEK_END:
                                $this->position = strlen($this->content) + $offset;
                                break;
                        }
                        return true;
                    }
                    
                    public function tell(): int
                    {
                        return $this->position;
                    }
                    
                    public function eof(): bool
                    {
                        return $this->position >= strlen($this->content);
                    }
                    
                    public function getContents(): string
                    {
                        $contents = substr($this->content, $this->position);
                        $this->position = strlen($this->content);
                        return $contents;
                    }
                    
                    public function getSize(): ?int
                    {
                        return strlen($this->content);
                    }
                    
                    public function close(): void
                    {
                        // No-op for string-based stream
                    }
                    
                    public function detach()
                    {
                        return null;
                    }
                    
                    public function isReadable(): bool
                    {
                        return true;
                    }
                    
                    public function isWritable(): bool
                    {
                        return true;
                    }
                    
                    public function isSeekable(): bool
                    {
                        return true;
                    }
                    
                    public function rewind(): void
                    {
                        $this->position = 0;
                    }
                    
                    public function getMetadata(?string $key = null)
                    {
                        return null;
                    }
                };
            }
            
            public function getHeaders(): array
            {
                return $this->response->headers();
            }
            
            public function hasHeader(string $name): bool
            {
                return $this->response->hasHeader($name);
            }
            
            public function getHeader(string $name): array
            {
                return $this->response->header($name) ? [$this->response->header($name)] : [];
            }
            
            public function getHeaderLine(string $name): string
            {
                return $this->response->header($name) ?? '';
            }
            
            public function withHeader(string $name, $value): \Psr\Http\Message\ResponseInterface
            {
                return $this;
            }
            
            public function withAddedHeader(string $name, $value): \Psr\Http\Message\ResponseInterface
            {
                return $this;
            }
            
            public function withoutHeader(string $name): \Psr\Http\Message\ResponseInterface
            {
                return $this;
            }
            
            public function withBody(\Psr\Http\Message\StreamInterface $body): \Psr\Http\Message\ResponseInterface
            {
                return $this;
            }
            
            public function getProtocolVersion(): string
            {
                return '1.1';
            }
            
            public function withProtocolVersion(string $version): \Psr\Http\Message\ResponseInterface
            {
                return $this;
            }
            
            public function getReasonPhrase(): string
            {
                return '';
            }
            
            public function withStatus(int $code, string $reasonPhrase = ''): \Psr\Http\Message\ResponseInterface
            {
                return $this;
            }
        };
    }
}
