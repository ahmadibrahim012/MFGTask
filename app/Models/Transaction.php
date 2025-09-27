<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Transaction extends Model
{
    use HasApiTokens, HasFactory, Notifiable,UUID;

    public function getReceiver(){
        return $this->belongsTo(User::class,'receiver_id','id');
    }
    public function getSender(){
        return $this->belongsTo(User::class,'sender_id','id');
    }

}
