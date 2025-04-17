<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Mail\BasicMail;
use Illuminate\Support\Facades\Mail;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail, LaratrustUser,JWTSubject
{
    use HasFactory, Notifiable, HasRolesAndPermissions;
    protected $guard = 'api';
    protected function getDefaultGuardName(): string { return 'api'; }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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

    public function sendEmailVerificationNotification()
    {
        return $this->generateEmailVerificationCode();
    }

    public function generateEmailVerificationCode()
    {
        $this->generateOtp();
        // Send the verification code via email
        Mail::to($this->email)->send(new BasicMail([
            'code' => $this->email_verify_otp,
            'subject' => __('Email Verification Code', [], get_lang_system()->slug),
            'message' => null
            // 'message' => __('Email Verification Code')
        ]));
    }

    public function generateOtp()
    {
        $this->email_verify_otp = rand(100000, 999999);
        $this->email_verify_otp_expires_at = Carbon::now()->addMinutes(60);
        $this->save();
    }

    public function hasValidOtp($code)
    {
        return $this->email_verify_otp === $code && Carbon::now()->lt($this->email_verify_otp_expires_at);
    }

    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
        $this->email_verify_otp = null;
        $this->email_verify_otp_expires_at = null;
        $this->save();
    }

    public function generatePasswordResetCode()
    {
        $this->generateOtp();

        $this->notify(new \App\Notifications\ResetPasswordCode($this->email_verify_otp));
    }

    public function hasAnyType($types)
    {
        return in_array($this->type, $types);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'student_id');
    }
    public function devices()
    {
        return $this->hasMany(Device::class, 'user_id');
    }
    public function device()
    {
        return $this->hasOne(Device::class, 'user_id');
    }


    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_student', 'student_id', 'lesson_id')
            ->withPivot('views')
            ->withTimestamps();
    }

}

