<?php

namespace Wavius\WhatsApp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Wavius Facade
 * 
 * Provides easy access to the Wavius service through Laravel's facade system.
 * 
 * @method static mixed sendMessage(string $to, string $message, ?string $instanceId = null)
 * @method static mixed sendImage(string $to, string $imagePath, ?string $caption = null, ?string $instanceId = null)
 * @method static mixed sendDocument(string $to, string $documentPath, ?string $caption = null, ?string $instanceId = null)
 * @method static mixed sendAudio(string $to, string $audioPath, ?string $instanceId = null)
 * @method static mixed sendVideo(string $to, string $videoPath, ?string $caption = null, ?string $instanceId = null)
 * @method static mixed sendLocation(string $to, float $latitude, float $longitude, ?string $name = null, ?string $address = null, ?string $instanceId = null)
 * @method static mixed sendContact(string $to, array $contact, ?string $instanceId = null)
 * @method static mixed getMessages(?string $instanceId = null, array $params = [])
 * @method static mixed getChats(?string $instanceId = null, array $params = [])
 * @method static mixed getContacts(?string $instanceId = null, array $params = [])
 * @method static mixed getGroups(?string $instanceId = null, array $params = [])
 * @method static mixed getInstanceStatus(?string $instanceId = null)
 * @method static mixed connectInstance(?string $instanceId = null)
 * @method static mixed disconnectInstance(?string $instanceId = null)
 * @method static mixed getQRCode(?string $instanceId = null)
 * @method static mixed getBusinessProfile(?string $instanceId = null)
 * @method static mixed updateBusinessProfile(array $data, ?string $instanceId = null)
 * @method static mixed getAnalytics(string $type, ?string $instanceId = null, array $params = [])
 * @method static mixed getReports(string $type, ?string $instanceId = null, array $params = [])
 * @method static mixed getQueueStats(?string $instanceId = null)
 * @method static mixed getWebhooks(?string $instanceId = null)
 * @method static mixed createWebhook(array $data, ?string $instanceId = null)
 * @method static mixed updateWebhook(string $webhookId, array $data, ?string $instanceId = null)
 * @method static mixed deleteWebhook(string $webhookId, ?string $instanceId = null)
 * @method static mixed uploadMedia(string $filePath, ?string $instanceId = null)
 * @method static mixed deleteMedia(string $mediaId, ?string $instanceId = null)
 * @method static mixed getMedia(string $mediaId, ?string $instanceId = null)
 * @method static mixed deleteMessage(array $data, ?string $instanceId = null)
 * @method static mixed resendMessage(string $messageId, ?string $instanceId = null)
 * @method static mixed resendMessagesByStatus(string $status, ?string $instanceId = null)
 * @method static mixed archiveChat(string $chatId, ?string $instanceId = null)
 * @method static mixed unarchiveChat(string $chatId, ?string $instanceId = null)
 * @method static mixed pinChat(string $chatId, ?string $instanceId = null)
 * @method static mixed unpinChat(string $chatId, ?string $instanceId = null)
 * @method static mixed deleteChat(string $chatId, ?string $instanceId = null)
 * @method static mixed updateContact(string $contactId, array $data, ?string $instanceId = null)
 * @method static mixed deleteContact(string $contactId, ?string $instanceId = null)
 * @method static mixed createGroup(array $data, ?string $instanceId = null)
 * @method static mixed updateGroup(string $groupId, array $data, ?string $instanceId = null)
 * @method static mixed deleteGroup(string $groupId, ?string $instanceId = null)
 * @method static mixed addParticipants(string $groupId, array $participants, ?string $instanceId = null)
 * @method static mixed removeParticipants(string $groupId, array $participants, ?string $instanceId = null)
 * @method static mixed promoteAdmins(string $groupId, array $participants, ?string $instanceId = null)
 * @method static mixed demoteAdmins(string $groupId, array $participants, ?string $instanceId = null)
 * @method static mixed getBusinessCatalog(?string $instanceId = null)
 * @method static mixed createBusinessCatalog(array $data, ?string $instanceId = null)
 * @method static mixed updateProduct(string $productId, array $data, ?string $instanceId = null)
 * @method static mixed deleteProduct(string $productId, ?string $instanceId = null)
 * @method static mixed getProduct(string $productId, ?string $instanceId = null)
 * @method static mixed cancelJob(string $jobId, ?string $instanceId = null)
 * @method static mixed getJob(string $jobId, ?string $instanceId = null)
 * @method static mixed setInstanceId(string $instanceId)
 * @method static mixed getInstanceId()
 * @method static mixed setToken(string $token)
 * @method static mixed getToken()
 */
class Wavius extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'wavius';
    }
}
