<?php

namespace Botble\EmailOrder\Models;

use Illuminate\Database\Eloquent\Model;

class OrderEmailNotification extends Model
{
    protected $table = 'order_email_notifications';

    protected $fillable = [
        'order_id',
        'message_content',
        'template_used',
        'status',
    ];
} 