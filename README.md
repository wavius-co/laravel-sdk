# Wavius WhatsApp Laravel SDK

A comprehensive Laravel package for integrating with the Wavius WhatsApp API. This package provides a clean, easy-to-use interface for sending WhatsApp messages, managing instances, and handling webhooks.

## Features

- 🚀 **Easy Integration**: Simple facade-based API for quick integration
- 📱 **Message Types**: Support for text, image, document, audio, video, location, and contact messages
- 🔧 **Instance Management**: Connect, disconnect, and manage WhatsApp instances
- 📊 **Analytics & Reports**: Access to analytics data and reports
- 🔔 **Webhook Support**: Built-in webhook handling for real-time events
- 🎯 **Business Features**: Business profile and catalog management
- 👥 **Group Management**: Create, update, and manage WhatsApp groups
- 📞 **Contact Management**: Manage contacts and their information
- 🗂️ **Chat Management**: Archive, pin, and manage chats
- 📈 **Queue Management**: Monitor and manage message queues
- 🎨 **Media Handling**: Upload, download, and manage media files
- 🔒 **Authentication**: Secure token-based authentication
- 📝 **Logging**: Comprehensive logging for debugging and monitoring
- ⚡ **Caching**: Built-in caching support for better performance
- 🛡️ **Rate Limiting**: Configurable rate limiting to prevent API abuse

## Installation

### Via Composer

```bash
composer require wavius-co/laravel-sdk
```

### Manual Installation

1. Clone the repository:
```bash
git clone https://github.com/wavius-co/laravel-sdk.git
```

2. Add to your `composer.json`:
```json
{
    "require": {
        "wavius-co/laravel-sdk": "*"
    }
}
```

3. Run composer install:
```bash
composer install
```

## Configuration

### Publishing Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Wavius\WhatsApp\WaviusServiceProvider" --tag="wavius-config"
```

### Environment Variables

Add the following environment variables to your `.env` file:

```env
# API Configuration
WAVIUS_API_BASE_URL=https://api.wavius.co
WAVIUS_API_VERSION=v1
WAVIUS_API_TIMEOUT=30
WAVIUS_API_RETRY_ATTEMPTS=3
WAVIUS_API_RETRY_DELAY=1000

# Authentication
WAVIUS_API_TOKEN=your_api_token_here
WAVIUS_TOKEN_HEADER=Authorization
WAVIUS_TOKEN_PREFIX=Bearer

# Instance Configuration
WAVIUS_DEFAULT_INSTANCE_ID=your_default_instance_id
WAVIUS_AUTO_CONNECT=false
WAVIUS_CONNECTION_TIMEOUT=60

# Webhook Configuration
WAVIUS_WEBHOOK_ENABLED=false
WAVIUS_WEBHOOK_SECRET=your_webhook_secret
WAVIUS_WEBHOOK_ENDPOINT=/webhooks/wavius
WAVIUS_VERIFY_WEBHOOK_SIGNATURE=true

# Queue Configuration
WAVIUS_QUEUE_ENABLED=true
WAVIUS_QUEUE_CONNECTION=default
WAVIUS_QUEUE_NAME=wavius
WAVIUS_QUEUE_RETRY_AFTER=90
WAVIUS_QUEUE_TRIES=3

# Logging Configuration
WAVIUS_LOGGING_ENABLED=true
WAVIUS_LOG_CHANNEL=stack
WAVIUS_LOG_LEVEL=info
WAVIUS_LOG_REQUESTS=false
WAVIUS_LOG_RESPONSES=false

# Route Configuration
WAVIUS_ROUTES_PREFIX=api/v1

# Cache Configuration
WAVIUS_CACHE_ENABLED=true
WAVIUS_CACHE_TTL=3600
WAVIUS_CACHE_PREFIX=wavius

# Media Configuration
WAVIUS_MEDIA_STORAGE_DISK=local
WAVIUS_MAX_FILE_SIZE=16777216

# Rate Limiting
WAVIUS_RATE_LIMITING_ENABLED=true
WAVIUS_RATE_LIMIT_PER_MINUTE=60
WAVIUS_RATE_LIMIT_BURST=10
```

## Usage

### Basic Usage

The package provides a facade for easy access to all functionality:

```php
use Wavius\WhatsApp\Facades\Wavius;

// Send a text message
Wavius::sendMessage('1234567890', 'Hello from Laravel!');

// Send an image with caption
Wavius::sendImage('1234567890', '/path/to/image.jpg', 'Check out this image!');

// Send a document
Wavius::sendDocument('1234567890', '/path/to/document.pdf', 'Important document');

// Send audio
Wavius::sendAudio('1234567890', '/path/to/audio.mp3');

// Send video
Wavius::sendVideo('1234567890', '/path/to/video.mp4', 'Check out this video!');

// Send location
Wavius::sendLocation('1234567890', 40.7128, -74.0060, 'New York', 'New York, NY');

// Send contact
Wavius::sendContact('1234567890', [
    'name' => 'John Doe',
    'phone' => '1234567890',
    'email' => 'john@example.com'
]);
```

### Instance Management

```php
// Get instance status
$status = Wavius::getInstanceStatus();

// Connect instance
Wavius::connectInstance();

// Disconnect instance
Wavius::disconnectInstance();

// Get QR code for connection
$qrCode = Wavius::getQRCode();
```

### Message Management

```php
// Get messages
$messages = Wavius::getMessages(null, [
    'limit' => 50,
    'offset' => 0
]);

// Delete message
Wavius::deleteMessage([
    'messageId' => 'message_id_here'
]);

// Resend message
Wavius::resendMessage('message_id_here');

// Resend messages by status
Wavius::resendMessagesByStatus('failed');
```

### Chat Management

```php
// Get chats
$chats = Wavius::getChats();

// Archive chat
Wavius::archiveChat('chat_id_here');

// Unarchive chat
Wavius::unarchiveChat('chat_id_here');

// Pin chat
Wavius::pinChat('chat_id_here');

// Unpin chat
Wavius::unpinChat('chat_id_here');

// Delete chat
Wavius::deleteChat('chat_id_here');
```

### Contact Management

```php
// Get contacts
$contacts = Wavius::getContacts();

// Update contact
Wavius::updateContact('contact_id_here', [
    'name' => 'Updated Name',
    'email' => 'updated@example.com'
]);

// Delete contact
Wavius::deleteContact('contact_id_here');
```

### Group Management

```php
// Get groups
$groups = Wavius::getGroups();

// Create group
Wavius::createGroup([
    'name' => 'My Group',
    'description' => 'Group description',
    'participants' => ['1234567890', '0987654321']
]);

// Update group
Wavius::updateGroup('group_id_here', [
    'name' => 'Updated Group Name',
    'description' => 'Updated description'
]);

// Delete group
Wavius::deleteGroup('group_id_here');

// Add participants
Wavius::addParticipants('group_id_here', ['1234567890', '0987654321']);

// Remove participants
Wavius::removeParticipants('group_id_here', ['1234567890']);

// Promote to admin
Wavius::promoteAdmins('group_id_here', ['1234567890']);

// Demote admin
Wavius::demoteAdmins('group_id_here', ['1234567890']);
```

### Business Features

```php
// Get business profile
$profile = Wavius::getBusinessProfile();

// Update business profile
Wavius::updateBusinessProfile([
    'name' => 'My Business',
    'description' => 'Business description',
    'email' => 'business@example.com',
    'phone' => '1234567890'
]);

// Get business catalog
$catalog = Wavius::getBusinessCatalog();

// Create business catalog
Wavius::createBusinessCatalog([
    'name' => 'Product Name',
    'description' => 'Product description',
    'price' => 99.99
]);

// Update product
Wavius::updateProduct('product_id_here', [
    'name' => 'Updated Product Name',
    'price' => 149.99
]);

// Delete product
Wavius::deleteProduct('product_id_here');

// Get product
$product = Wavius::getProduct('product_id_here');
```

### Analytics & Reports

```php
// Get analytics
$contactAnalytics = Wavius::getAnalytics('contacts');
$groupAnalytics = Wavius::getAnalytics('groups');
$messageAnalytics = Wavius::getAnalytics('messages');

// Get reports
$statusReport = Wavius::getReports('status');
$usageReport = Wavius::getReports('usage');
```

### Webhook Management

```php
// Get webhooks
$webhooks = Wavius::getWebhooks();

// Create webhook
Wavius::createWebhook([
    'url' => 'https://your-domain.com/webhooks/wavius',
    'events' => ['message', 'status']
]);

// Update webhook
Wavius::updateWebhook('webhook_id_here', [
    'url' => 'https://your-domain.com/webhooks/wavius-updated',
    'events' => ['message', 'status', 'media']
]);

// Delete webhook
Wavius::deleteWebhook('webhook_id_here');
```

### Media Management

```php
// Upload media
$media = Wavius::uploadMedia('/path/to/file.jpg');

// Get media
$mediaInfo = Wavius::getMedia('media_id_here');

// Delete media
Wavius::deleteMedia('media_id_here');
```

### Queue Management

```php
// Get queue stats
$stats = Wavius::getQueueStats();

// Get job details
$job = Wavius::getJob('job_id_here');

// Cancel job
Wavius::cancelJob('job_id_here');
```

### Using Different Instances

```php
// Set instance ID for specific operations
Wavius::setInstanceId('instance_id_here');

// Or pass instance ID to individual methods
Wavius::sendMessage('1234567890', 'Hello!', 'instance_id_here');
Wavius::getMessages('instance_id_here');
```

### Dependency Injection

You can also inject the service directly:

```php
use Wavius\WhatsApp\Services\WaviusService;

class MyController extends Controller
{
    public function __construct(
        private WaviusService $wavius
    ) {}

    public function sendMessage()
    {
        $this->wavius->sendMessage('1234567890', 'Hello from controller!');
    }
}
```

## Webhook Handling

### Creating Webhook Controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Wavius\WhatsApp\Facades\Wavius;

class WaviusWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Verify webhook signature if enabled
        if (config('wavius.webhook.verify_signature')) {
            $this->verifySignature($request);
        }

        $payload = $request->all();
        $event = $payload['event'] ?? null;

        switch ($event) {
            case 'message':
                $this->handleMessage($payload);
                break;
            case 'status':
                $this->handleStatus($payload);
                break;
            case 'media':
                $this->handleMedia($payload);
                break;
            default:
                // Handle unknown event
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    private function handleMessage($payload)
    {
        // Handle incoming message
        $message = $payload['data'] ?? [];
        
        // Your message handling logic here
        Log::info('Received WhatsApp message', $message);
    }

    private function handleStatus($payload)
    {
        // Handle status update
        $status = $payload['data'] ?? [];
        
        // Your status handling logic here
        Log::info('Received WhatsApp status update', $status);
    }

    private function handleMedia($payload)
    {
        // Handle media event
        $media = $payload['data'] ?? [];
        
        // Your media handling logic here
        Log::info('Received WhatsApp media event', $media);
    }

    private function verifySignature(Request $request)
    {
        $signature = $request->header('X-Wavius-Signature');
        $payload = $request->getContent();
        $secret = config('wavius.webhook.secret');

        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($expectedSignature, $signature)) {
            abort(401, 'Invalid webhook signature');
        }
    }
}
```

### Adding Webhook Route

```php
// In routes/web.php or routes/api.php
Route::post('/webhooks/wavius', [WaviusWebhookController::class, 'handle']);
```

## Error Handling

The package throws exceptions for API errors:

```php
use Wavius\WhatsApp\Facades\Wavius;

try {
    $result = Wavius::sendMessage('1234567890', 'Hello!');
} catch (\Exception $e) {
    // Handle error
    Log::error('Wavius API Error: ' . $e->getMessage());
}
```

## Logging

The package includes comprehensive logging. Enable it in your configuration:

```env
WAVIUS_LOGGING_ENABLED=true
WAVIUS_LOG_REQUESTS=true
WAVIUS_LOG_RESPONSES=true
```

## Caching

Enable caching for better performance:

```env
WAVIUS_CACHE_ENABLED=true
WAVIUS_CACHE_TTL=3600
```

## Rate Limiting

Configure rate limiting to prevent API abuse:

```env
WAVIUS_RATE_LIMITING_ENABLED=true
WAVIUS_RATE_LIMIT_PER_MINUTE=60
WAVIUS_RATE_LIMIT_BURST=10
```

## Testing

The package includes comprehensive tests. Run them with:

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For support, please contact:
- Email: support@wavius.co
- Website: https://wavius.co
- Documentation: https://docs.wavius.co

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for more information on what has changed recently.
