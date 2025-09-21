<?php

namespace App\Jobs;

use App\Models\NotificationLog;
use App\Models\User;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsappNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $guardian;
    protected $message;
    protected $guardianPhone;

    /**
     * Create a new job instance.
     */
    public function __construct(User $student, User $guardian, string $message)
    {
        $this->student = $student;
        $this->guardian = $guardian;
        $this->message = $message;
        $this->guardianPhone = $guardian->guardian_phone;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsappService $whatsappService): void
    {
        if (!$this->guardianPhone) {
            // Jika wali murid tidak punya nomor HP, log sebagai gagal
             NotificationLog::create([
                'user_id' => $this->guardian->id,
                'message' => $this->message,
                'status' => 'failed',
                'response' => 'Guardian phone number is not set.',
            ]);
            return;
        }

        $result = $whatsappService->sendMessage($this->guardianPhone, $this->message);

        // Simpan hasil pengiriman ke log
        NotificationLog::create([
            'user_id' => $this->guardian->id,
            'message' => $this->message,
            'status' => $result['success'] ? 'success' : 'failed',
            'response' => is_string($result['response']) ? $result['response'] : json_encode($result['response']),
        ]);
    }
}
