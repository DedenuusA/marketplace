<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Customer extends Authenticatable
{
   use HasApiTokens, HasFactory, Notifiable ;

    protected $primaryKey = 'id';
    protected $table = 'customers';
    protected $fillable = [
        'nama',
        'email',
        'password',
        'phone_number',
        'jenis_kelamin',
        'alamat',
        'gambar'
    ];
 public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute()
{
    return \Carbon\Carbon::parse($this->attributes['created_at'])->setTimezone('Asia/Jakarta')
       ->format('d, M Y H:i');
}

}
