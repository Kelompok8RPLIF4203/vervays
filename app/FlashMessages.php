<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlashMessages extends Model
{
    protected $table = 'flash_messages';
    public $timestamps = false;

    protected $fillable = [
        'userId',
        'message',
        'type',
        'allotmentId'
    ];

    protected $attributes = [
        "message" => '-',
        "type" => 'info',
    ];
}
