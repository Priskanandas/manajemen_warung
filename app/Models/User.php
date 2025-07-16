<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    protected static $logAttributes = ['name', 'email'];
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'user';

    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} user";
    }

    //public function getIsAdminAttribute()
    //{
      //  return $this->hasRole('Admin');
    //}

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_pelayan');
    }

    public function warungs()
    {
        return $this->hasMany(Warung::class, 'user_id');
    }
}
