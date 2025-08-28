<?php

namespace Wavius\WhatsApp\Services;

use Wavius\WhatsApp\Config\WaviusConfig;
use Wavius\WhatsApp\Contracts\WaviusClientInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

/**
 * Wavius Service
 * 
 * Main service class for the Wavius WhatsApp Laravel SDK.
 * Provides high-level methods for WhatsApp operations.
 */
class WaviusService
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly WaviusClientInterface $client,
        private readonly WaviusConfig $config
    ) {
        // Set default instance ID if configured
        if ($this->config->getDefaultInstanceId()) {
            $this->client->setInstanceId($this->config->getDefaultInstanceId());
        }

        // Set authentication token if configured
        if ($this->config->getAuthToken()) {
            $this->client->setToken($this->config->getAuthToken());
        }
    }

    /**
     * Send a text message
     */
    public function sendMessage(string $to, string $message, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = [
            'to' => $to,
            'message' => $message,
        ];

        $this->logRequest('sendMessage', $data);
        
        $response = $this->client->post('/messages/chat', $data);
        
        $this->logResponse('sendMessage', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Send an image message
     */
    public function sendImage(string $to, string $imagePath, ?string $caption = null, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = [
            'to' => $to,
            'image' => $imagePath,
        ];

        if ($caption) {
            $data['caption'] = $caption;
        }

        $this->logRequest('sendImage', $data);
        
        $response = $this->client->post('/messages/image', $data);
        
        $this->logResponse('sendImage', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Send a document message
     */
    public function sendDocument(string $to, string $documentPath, ?string $caption = null, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = [
            'to' => $to,
            'document' => $documentPath,
        ];

        if ($caption) {
            $data['caption'] = $caption;
        }

        $this->logRequest('sendDocument', $data);
        
        $response = $this->client->post('/messages/document', $data);
        
        $this->logResponse('sendDocument', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Send an audio message
     */
    public function sendAudio(string $to, string $audioPath, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = [
            'to' => $to,
            'audio' => $audioPath,
        ];

        $this->logRequest('sendAudio', $data);
        
        $response = $this->client->post('/messages/audio', $data);
        
        $this->logResponse('sendAudio', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Send a video message
     */
    public function sendVideo(string $to, string $videoPath, ?string $caption = null, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = [
            'to' => $to,
            'video' => $videoPath,
        ];

        if ($caption) {
            $data['caption'] = $caption;
        }

        $this->logRequest('sendVideo', $data);
        
        $response = $this->client->post('/messages/video', $data);
        
        $this->logResponse('sendVideo', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Send a location message
     */
    public function sendLocation(string $to, float $latitude, float $longitude, ?string $name = null, ?string $address = null, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = [
            'to' => $to,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        if ($name) {
            $data['name'] = $name;
        }

        if ($address) {
            $data['address'] = $address;
        }

        $this->logRequest('sendLocation', $data);
        
        $response = $this->client->post('/messages/location', $data);
        
        $this->logResponse('sendLocation', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Send a contact message
     */
    public function sendContact(string $to, array $contact, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = [
            'to' => $to,
            'contact' => $contact,
        ];

        $this->logRequest('sendContact', $data);
        
        $response = $this->client->post('/messages/contact', $data);
        
        $this->logResponse('sendContact', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get messages
     */
    public function getMessages(?string $instanceId = null, array $params = []): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getMessages', $params);
        
        $response = $this->client->get('/messages', $params);
        
        $this->logResponse('getMessages', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get chats
     */
    public function getChats(?string $instanceId = null, array $params = []): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getChats', $params);
        
        $response = $this->client->get('/chats', $params);
        
        $this->logResponse('getChats', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get contacts
     */
    public function getContacts(?string $instanceId = null, array $params = []): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getContacts', $params);
        
        $response = $this->client->get('/contacts', $params);
        
        $this->logResponse('getContacts', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get groups
     */
    public function getGroups(?string $instanceId = null, array $params = []): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getGroups', $params);
        
        $response = $this->client->get('/groups', $params);
        
        $this->logResponse('getGroups', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get instance status
     */
    public function getInstanceStatus(?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getInstanceStatus', []);
        
        $response = $this->client->get('/status');
        
        $this->logResponse('getInstanceStatus', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Connect instance
     */
    public function connectInstance(?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('connectInstance', []);
        
        $response = $this->client->post('/connect');
        
        $this->logResponse('connectInstance', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Disconnect instance
     */
    public function disconnectInstance(?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('disconnectInstance', []);
        
        $response = $this->client->delete('/disconnect');
        
        $this->logResponse('disconnectInstance', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get QR code
     */
    public function getQRCode(?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getQRCode', []);
        
        $response = $this->client->get('/qr');
        
        $this->logResponse('getQRCode', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get business profile
     */
    public function getBusinessProfile(?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getBusinessProfile', []);
        
        $response = $this->client->get('/business/profile');
        
        $this->logResponse('getBusinessProfile', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Update business profile
     */
    public function updateBusinessProfile(array $data, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('updateBusinessProfile', $data);
        
        $response = $this->client->put('/business/profile', $data);
        
        $this->logResponse('updateBusinessProfile', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get analytics
     */
    public function getAnalytics(string $type, ?string $instanceId = null, array $params = []): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getAnalytics', array_merge(['type' => $type], $params));
        
        $response = $this->client->get("/analytics/{$type}", $params);
        
        $this->logResponse('getAnalytics', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get reports
     */
    public function getReports(string $type, ?string $instanceId = null, array $params = []): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getReports', array_merge(['type' => $type], $params));
        
        $response = $this->client->get("/reports/{$type}", $params);
        
        $this->logResponse('getReports', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get queue stats
     */
    public function getQueueStats(?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getQueueStats', []);
        
        $response = $this->client->get('/queue/stats');
        
        $this->logResponse('getQueueStats', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get webhooks
     */
    public function getWebhooks(?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getWebhooks', []);
        
        $response = $this->client->get('/webhooks');
        
        $this->logResponse('getWebhooks', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Create webhook
     */
    public function createWebhook(array $data, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('createWebhook', $data);
        
        $response = $this->client->post('/webhooks', $data);
        
        $this->logResponse('createWebhook', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Update webhook
     */
    public function updateWebhook(string $webhookId, array $data, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('updateWebhook', array_merge(['webhookId' => $webhookId], $data));
        
        $response = $this->client->put("/webhooks/{$webhookId}", $data);
        
        $this->logResponse('updateWebhook', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Delete webhook
     */
    public function deleteWebhook(string $webhookId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('deleteWebhook', ['webhookId' => $webhookId]);
        
        $response = $this->client->delete("/webhooks/{$webhookId}");
        
        $this->logResponse('deleteWebhook', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Upload media
     */
    public function uploadMedia(string $filePath, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('uploadMedia', ['filePath' => $filePath]);
        
        $response = $this->client->upload('/media/upload', $filePath);
        
        $this->logResponse('uploadMedia', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Delete media
     */
    public function deleteMedia(string $mediaId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('deleteMedia', ['mediaId' => $mediaId]);
        
        $response = $this->client->delete("/media/{$mediaId}");
        
        $this->logResponse('deleteMedia', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get media
     */
    public function getMedia(string $mediaId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getMedia', ['mediaId' => $mediaId]);
        
        $response = $this->client->get("/media/{$mediaId}");
        
        $this->logResponse('getMedia', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Delete message
     */
    public function deleteMessage(array $data, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('deleteMessage', $data);
        
        $response = $this->client->delete('/messages/delete', $data);
        
        $this->logResponse('deleteMessage', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Resend message by ID
     */
    public function resendMessage(string $messageId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = ['messageId' => $messageId];

        $this->logRequest('resendMessage', $data);
        
        $response = $this->client->post('/messages/resend-by-id', $data);
        
        $this->logResponse('resendMessage', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Resend messages by status
     */
    public function resendMessagesByStatus(string $status, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = ['status' => $status];

        $this->logRequest('resendMessagesByStatus', $data);
        
        $response = $this->client->post('/messages/resend-by-status', $data);
        
        $this->logResponse('resendMessagesByStatus', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Archive chat
     */
    public function archiveChat(string $chatId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('archiveChat', ['chatId' => $chatId]);
        
        $response = $this->client->post("/chats/{$chatId}/archive");
        
        $this->logResponse('archiveChat', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Unarchive chat
     */
    public function unarchiveChat(string $chatId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('unarchiveChat', ['chatId' => $chatId]);
        
        $response = $this->client->post("/chats/{$chatId}/unarchive");
        
        $this->logResponse('unarchiveChat', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Pin chat
     */
    public function pinChat(string $chatId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('pinChat', ['chatId' => $chatId]);
        
        $response = $this->client->post("/chats/{$chatId}/pin");
        
        $this->logResponse('pinChat', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Unpin chat
     */
    public function unpinChat(string $chatId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('unpinChat', ['chatId' => $chatId]);
        
        $response = $this->client->post("/chats/{$chatId}/unpin");
        
        $this->logResponse('unpinChat', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Delete chat
     */
    public function deleteChat(string $chatId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('deleteChat', ['chatId' => $chatId]);
        
        $response = $this->client->delete("/chats/{$chatId}");
        
        $this->logResponse('deleteChat', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Update contact
     */
    public function updateContact(string $contactId, array $data, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('updateContact', array_merge(['contactId' => $contactId], $data));
        
        $response = $this->client->put("/contacts/{$contactId}", $data);
        
        $this->logResponse('updateContact', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Delete contact
     */
    public function deleteContact(string $contactId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('deleteContact', ['contactId' => $contactId]);
        
        $response = $this->client->delete("/contacts/{$contactId}");
        
        $this->logResponse('deleteContact', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Create group
     */
    public function createGroup(array $data, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('createGroup', $data);
        
        $response = $this->client->post('/groups', $data);
        
        $this->logResponse('createGroup', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Update group
     */
    public function updateGroup(string $groupId, array $data, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('updateGroup', array_merge(['groupId' => $groupId], $data));
        
        $response = $this->client->put("/groups/{$groupId}", $data);
        
        $this->logResponse('updateGroup', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Delete group
     */
    public function deleteGroup(string $groupId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('deleteGroup', ['groupId' => $groupId]);
        
        $response = $this->client->delete("/groups/{$groupId}");
        
        $this->logResponse('deleteGroup', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Add participants to group
     */
    public function addParticipants(string $groupId, array $participants, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = ['participants' => $participants];

        $this->logRequest('addParticipants', array_merge(['groupId' => $groupId], $data));
        
        $response = $this->client->post("/groups/{$groupId}/participants", $data);
        
        $this->logResponse('addParticipants', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Remove participants from group
     */
    public function removeParticipants(string $groupId, array $participants, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = ['participants' => $participants];

        $this->logRequest('removeParticipants', array_merge(['groupId' => $groupId], $data));
        
        $response = $this->client->delete("/groups/{$groupId}/participants", $data);
        
        $this->logResponse('removeParticipants', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Promote participants to admins
     */
    public function promoteAdmins(string $groupId, array $participants, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = ['participants' => $participants];

        $this->logRequest('promoteAdmins', array_merge(['groupId' => $groupId], $data));
        
        $response = $this->client->post("/groups/{$groupId}/admins", $data);
        
        $this->logResponse('promoteAdmins', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Demote admins to participants
     */
    public function demoteAdmins(string $groupId, array $participants, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $data = ['participants' => $participants];

        $this->logRequest('demoteAdmins', array_merge(['groupId' => $groupId], $data));
        
        $response = $this->client->delete("/groups/{$groupId}/admins", $data);
        
        $this->logResponse('demoteAdmins', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get business catalog
     */
    public function getBusinessCatalog(?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getBusinessCatalog', []);
        
        $response = $this->client->get('/business/catalog');
        
        $this->logResponse('getBusinessCatalog', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Create business catalog
     */
    public function createBusinessCatalog(array $data, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('createBusinessCatalog', $data);
        
        $response = $this->client->post('/business/catalog', $data);
        
        $this->logResponse('createBusinessCatalog', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Update product
     */
    public function updateProduct(string $productId, array $data, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('updateProduct', array_merge(['productId' => $productId], $data));
        
        $response = $this->client->put("/business/catalog/{$productId}", $data);
        
        $this->logResponse('updateProduct', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Delete product
     */
    public function deleteProduct(string $productId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('deleteProduct', ['productId' => $productId]);
        
        $response = $this->client->delete("/business/catalog/{$productId}");
        
        $this->logResponse('deleteProduct', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get product
     */
    public function getProduct(string $productId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getProduct', ['productId' => $productId]);
        
        $response = $this->client->get("/business/catalog/{$productId}");
        
        $this->logResponse('getProduct', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Cancel job
     */
    public function cancelJob(string $jobId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('cancelJob', ['jobId' => $jobId]);
        
        $response = $this->client->delete("/queue/jobs/{$jobId}");
        
        $this->logResponse('cancelJob', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Get job
     */
    public function getJob(string $jobId, ?string $instanceId = null): mixed
    {
        $this->setInstanceId($instanceId);

        $this->logRequest('getJob', ['jobId' => $jobId]);
        
        $response = $this->client->get("/queue/jobs/{$jobId}");
        
        $this->logResponse('getJob', $response);
        
        return $this->parseResponse($response);
    }

    /**
     * Set instance ID
     */
    public function setInstanceId(?string $instanceId): void
    {
        if ($instanceId) {
            $this->client->setInstanceId($instanceId);
        }
    }

    /**
     * Get instance ID
     */
    public function getInstanceId(): ?string
    {
        return $this->client->getInstanceId();
    }

    /**
     * Set token
     */
    public function setToken(string $token): void
    {
        $this->client->setToken($token);
    }

    /**
     * Get token
     */
    public function getToken(): ?string
    {
        return $this->client->getToken();
    }

    /**
     * Set instance ID for the client
     */
    private function setInstanceIdForClient(?string $instanceId): void
    {
        if ($instanceId) {
            $this->client->setInstanceId($instanceId);
        }
    }

    /**
     * Log request if logging is enabled
     */
    private function logRequest(string $method, array $data): void
    {
        if ($this->config->isRequestLoggingEnabled()) {
            Log::channel($this->config->getLogChannel())->log(
                $this->config->getLogLevel(),
                "Wavius API Request: {$method}",
                [
                    'method' => $method,
                    'data' => $data,
                    'instance_id' => $this->client->getInstanceId(),
                ]
            );
        }
    }

    /**
     * Log response if logging is enabled
     */
    private function logResponse(string $method, $response): void
    {
        if ($this->config->isResponseLoggingEnabled()) {
            Log::channel($this->config->getLogChannel())->log(
                $this->config->getLogLevel(),
                "Wavius API Response: {$method}",
                [
                    'method' => $method,
                    'status_code' => $response->getStatusCode(),
                    'body' => $response->getBody()->getContents(),
                ]
            );
        }
    }

    /**
     * Parse response and handle caching
     */
    private function parseResponse($response): mixed
    {
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        
        // Parse JSON response
        $data = json_decode($body, true);
        
        // Handle errors
        if ($statusCode >= 400) {
            throw new \Exception("Wavius API Error: {$statusCode} - " . ($data['message'] ?? $body));
        }
        
        return $data;
    }
}
