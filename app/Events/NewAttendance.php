<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Storage;

class NewAttendance implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Data absensi yang akan disiarkan.
     * Properti ini harus public agar bisa diakses oleh frontend.
     * @var array
     */
    public $attendanceData;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\User $student
     * @param \App\Models\Attendance $attendance
     */
    public function __construct(User $student, Attendance $attendance)
    {
        // Menentukan URL foto: gunakan foto asli jika ada, jika tidak, gunakan UI Avatars.
        $photoUrl = $student->photo
            ? Storage::url($student->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=random&size=150';

        // Membangun data yang akan dikirim ke halaman monitor
        $this->attendanceData = [
            'student_name' => $student->name,
            'class' => $student->class,
            'status' => $attendance->status,
            'time' => $attendance->recorded_at->format('H:i:s'),
            'photo_url' => $photoUrl,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Menyiarkan event ke channel publik bernama 'attendance-channel'
        return [
            new Channel('attendance-channel'),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        // Memberi nama event agar mudah dikenali oleh frontend (JavaScript)
        return 'new-attendance-event';
    }
}

