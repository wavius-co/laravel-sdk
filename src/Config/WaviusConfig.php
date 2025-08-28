<?php

namespace Wavius\WhatsApp\Config;

/**
 * Wavius Configuration Class
 * 
 * Handles configuration management for the Wavius package.
 * Provides typed access to configuration values with validation.
 */
class WaviusConfig
{
    /**
     * Configuration array
     */
    private array $config;

    /**
     * Constructor
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Get API base URL
     */
    public function getApiBaseUrl(): string
    {
        return $this->config['api']['base_url'] ?? 'https://api.wavius.co';
    }

    /**
     * Get API version
     */
    public function getApiVersion(): string
    {
        return $this->config['api']['version'] ?? 'v1';
    }

    /**
     * Get API timeout
     */
    public function getApiTimeout(): int
    {
        return (int) ($this->config['api']['timeout'] ?? 30);
    }

    /**
     * Get API retry attempts
     */
    public function getApiRetryAttempts(): int
    {
        return (int) ($this->config['api']['retry_attempts'] ?? 3);
    }

    /**
     * Get API retry delay
     */
    public function getApiRetryDelay(): int
    {
        return (int) ($this->config['api']['retry_delay'] ?? 1000);
    }

    /**
     * Get authentication token
     */
    public function getAuthToken(): ?string
    {
        return $this->config['auth']['token'] ?? null;
    }

    /**
     * Get token header name
     */
    public function getTokenHeader(): string
    {
        return $this->config['auth']['token_header'] ?? 'Authorization';
    }

    /**
     * Get token prefix
     */
    public function getTokenPrefix(): string
    {
        return $this->config['auth']['token_prefix'] ?? 'Bearer';
    }

    /**
     * Get default instance ID
     */
    public function getDefaultInstanceId(): ?string
    {
        return $this->config['instance']['default_id'] ?? null;
    }

    /**
     * Check if auto connect is enabled
     */
    public function isAutoConnectEnabled(): bool
    {
        return (bool) ($this->config['instance']['auto_connect'] ?? false);
    }

    /**
     * Get connection timeout
     */
    public function getConnectionTimeout(): int
    {
        return (int) ($this->config['instance']['connection_timeout'] ?? 60);
    }

    /**
     * Check if webhooks are enabled
     */
    public function isWebhookEnabled(): bool
    {
        return (bool) ($this->config['webhook']['enabled'] ?? false);
    }

    /**
     * Get webhook secret
     */
    public function getWebhookSecret(): ?string
    {
        return $this->config['webhook']['secret'] ?? null;
    }

    /**
     * Get webhook endpoint
     */
    public function getWebhookEndpoint(): string
    {
        return $this->config['webhook']['endpoint'] ?? '/webhooks/wavius';
    }

    /**
     * Check if webhook signature verification is enabled
     */
    public function isWebhookSignatureVerificationEnabled(): bool
    {
        return (bool) ($this->config['webhook']['verify_signature'] ?? true);
    }

    /**
     * Check if queue is enabled
     */
    public function isQueueEnabled(): bool
    {
        return (bool) ($this->config['queue']['enabled'] ?? true);
    }

    /**
     * Get queue connection
     */
    public function getQueueConnection(): string
    {
        return $this->config['queue']['connection'] ?? 'default';
    }

    /**
     * Get queue name
     */
    public function getQueueName(): string
    {
        return $this->config['queue']['queue_name'] ?? 'wavius';
    }

    /**
     * Get queue retry after
     */
    public function getQueueRetryAfter(): int
    {
        return (int) ($this->config['queue']['retry_after'] ?? 90);
    }

    /**
     * Get queue tries
     */
    public function getQueueTries(): int
    {
        return (int) ($this->config['queue']['tries'] ?? 3);
    }

    /**
     * Check if logging is enabled
     */
    public function isLoggingEnabled(): bool
    {
        return (bool) ($this->config['logging']['enabled'] ?? true);
    }

    /**
     * Get log channel
     */
    public function getLogChannel(): string
    {
        return $this->config['logging']['channel'] ?? 'stack';
    }

    /**
     * Get log level
     */
    public function getLogLevel(): string
    {
        return $this->config['logging']['level'] ?? 'info';
    }

    /**
     * Check if request logging is enabled
     */
    public function isRequestLoggingEnabled(): bool
    {
        return (bool) ($this->config['logging']['log_requests'] ?? false);
    }

    /**
     * Check if response logging is enabled
     */
    public function isResponseLoggingEnabled(): bool
    {
        return (bool) ($this->config['logging']['log_responses'] ?? false);
    }

    /**
     * Get routes prefix
     */
    public function getRoutesPrefix(): string
    {
        return $this->config['routes']['prefix'] ?? 'api/v1';
    }

    /**
     * Get routes middleware
     */
    public function getRoutesMiddleware(): array
    {
        return $this->config['routes']['middleware'] ?? ['api'];
    }

    /**
     * Get auth middleware
     */
    public function getAuthMiddleware(): array
    {
        return $this->config['routes']['auth_middleware'] ?? ['wavius.auth'];
    }

    /**
     * Check if cache is enabled
     */
    public function isCacheEnabled(): bool
    {
        return (bool) ($this->config['cache']['enabled'] ?? true);
    }

    /**
     * Get cache TTL
     */
    public function getCacheTtl(): int
    {
        return (int) ($this->config['cache']['ttl'] ?? 3600);
    }

    /**
     * Get cache prefix
     */
    public function getCachePrefix(): string
    {
        return $this->config['cache']['prefix'] ?? 'wavius';
    }

    /**
     * Get media storage disk
     */
    public function getMediaStorageDisk(): string
    {
        return $this->config['media']['storage_disk'] ?? 'local';
    }

    /**
     * Get max file size
     */
    public function getMaxFileSize(): int
    {
        return (int) ($this->config['media']['max_file_size'] ?? 16777216);
    }

    /**
     * Get allowed media types
     */
    public function getAllowedMediaTypes(): array
    {
        return $this->config['media']['allowed_types'] ?? [];
    }

    /**
     * Check if rate limiting is enabled
     */
    public function isRateLimitingEnabled(): bool
    {
        return (bool) ($this->config['rate_limiting']['enabled'] ?? true);
    }

    /**
     * Get requests per minute
     */
    public function getRequestsPerMinute(): int
    {
        return (int) ($this->config['rate_limiting']['requests_per_minute'] ?? 60);
    }

    /**
     * Get burst limit
     */
    public function getBurstLimit(): int
    {
        return (int) ($this->config['rate_limiting']['burst_limit'] ?? 10);
    }

    /**
     * Get full configuration array
     */
    public function all(): array
    {
        return $this->config;
    }

    /**
     * Get configuration value by key
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return \Illuminate\Support\Arr::get($this->config, $key, $default);
    }
}
