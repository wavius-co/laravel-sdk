<?php

namespace Wavius\WhatsApp\Contracts;

use Psr\Http\Message\ResponseInterface;

/**
 * Wavius Client Interface
 * 
 * Defines the contract for Wavius API client implementations.
 * Provides methods for making HTTP requests to the Wavius API.
 */
interface WaviusClientInterface
{
    /**
     * Make a GET request to the Wavius API
     */
    public function get(string $endpoint, array $params = []): ResponseInterface;

    /**
     * Make a POST request to the Wavius API
     */
    public function post(string $endpoint, array $data = []): ResponseInterface;

    /**
     * Make a PUT request to the Wavius API
     */
    public function put(string $endpoint, array $data = []): ResponseInterface;

    /**
     * Make a DELETE request to the Wavius API
     */
    public function delete(string $endpoint, array $params = []): ResponseInterface;

    /**
     * Upload a file to the Wavius API
     */
    public function upload(string $endpoint, string $filePath, array $data = []): ResponseInterface;

    /**
     * Set the authentication token
     */
    public function setToken(string $token): void;

    /**
     * Get the current authentication token
     */
    public function getToken(): ?string;

    /**
     * Set the instance ID for requests
     */
    public function setInstanceId(string $instanceId): void;

    /**
     * Get the current instance ID
     */
    public function getInstanceId(): ?string;
}
