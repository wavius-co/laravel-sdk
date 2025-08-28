<?php

namespace Wavius\WhatsApp\Contracts;

use Psr\Http\Message\ResponseInterface;

/**
 * WhatsApp Client Interface
 * 
 * Defines the contract for WhatsApp API client implementations.
 * Provides methods for making HTTP requests to the WhatsApp API.
 */
interface WhatsAppClientInterface
{
    /**
     * Make a GET request to the WhatsApp API
     */
    public function get(string $endpoint, array $params = []): ResponseInterface;

    /**
     * Make a POST request to the WhatsApp API
     */
    public function post(string $endpoint, array $data = []): ResponseInterface;

    /**
     * Make a PUT request to the WhatsApp API
     */
    public function put(string $endpoint, array $data = []): ResponseInterface;

    /**
     * Make a DELETE request to the WhatsApp API
     */
    public function delete(string $endpoint, array $params = []): ResponseInterface;

    /**
     * Upload a file to the WhatsApp API
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
