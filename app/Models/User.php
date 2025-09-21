<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        // Student specific
        'nis',
        'class',
        'photo',
        'card_uid',
        'fingerprint_id',
        'guardian_id',
        // Guardian specific
        'guardian_name',
        'guardian_phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the grade part from the 'class' attribute.
     * Accessor ini memungkinkan kita memanggil $user->grade
     * @return string|null
     */
    public function getGradeAttribute(): ?string
    {
        if ($this->class) {
            $parts = explode(' ', $this->class, 2);
            return $parts[0] ?? null;
        }
        return null;
    }

    /**
     * Get the major part from the 'class' attribute.
     * Accessor ini memungkinkan kita memanggil $user->major
     * @return string|null
     */
    public function getMajorAttribute(): ?string
    {
        if ($this->class) {
            $parts = explode(' ', $this->class, 2);
            return $parts[1] ?? null;
        }
        return null;
    }


    /**
     * Scope a query to only include students.
     */
    public function scopeStudent(Builder $query): void
    {
        $query->where('role', 'siswa');
    }

    /**
     * Scope a query to only include guardians.
     */
    public function scopeGuardian(Builder $query): void
    {
        $query->where('role', 'wali');
    }

    /**
     * Get the attendances for the user.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the leave requests for the student.
     */
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    /**
     * Get the guardian for the student.
     */
    public function guardian()
    {
        return $this->belongsTo(User::class, 'guardian_id');
    }

    /**
     * Get the students (wards) for the guardian.
     */
    public function students()
    {
        return $this->hasMany(User::class, 'guardian_id');
    }
}

