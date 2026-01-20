<?php

namespace App\Services;

use App\Models\Notifications;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * Send a notification via multiple channels.
     *
     * @param int $userId The recipient user ID
     * @param string $title The notification title
     * @param string $message The notification body
     * @param array $channels Array of channels: ['database', 'email', 'sms', 'firebase']
     * @param string $type Notification type (e.g., 'info', 'warning')
     * @param array $data Additional data
     */
    public function send($userId, $title, $message, $channels = ['database'], $type = 'info', $data = [])
    {
        foreach ($channels as $channel) {
            try {
                switch ($channel) {
                    case 'database':
                        $this->toDatabase($userId, $title, $message, $type, $data);
                        break;
                    case 'email':
                        $this->toEmail($userId, $title, $message);
                        break;
                    case 'sms':
                    case 'whatsapp':
                        $this->toSms($userId, $message); // Placeholder
                        break;
                    case 'firebase':
                        $this->toFirebase($userId, $title, $message); // Placeholder
                        break;
                }
            } catch (\Exception $e) {
                Log::error("Failed to send notification via $channel: " . $e->getMessage());
            }
        }
    }

    protected function toDatabase($userId, $title, $message, $type, $data)
    {
        Notifications::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false,
            'data' => $data
        ]);
    }

    protected function toEmail($userId, $title, $message)
    {
        // Placeholder for Email Logic
        // Mail::to($user->email)->send(new NotificationMail($title, $message));
        Log::info("Email sent to User $userId: $title");
    }

    protected function toSms($userId, $message)
    {
        // Placeholder for SMS/WhatsApp API (e.g., Twilio)
        Log::info("SMS/WhatsApp sent to User $userId: $message");
    }

    protected function toFirebase($userId, $title, $message)
    {
        // Placeholder for Firebase Cloud Messaging
        Log::info("Firebase notification sent to User $userId: $title");
    }
}
