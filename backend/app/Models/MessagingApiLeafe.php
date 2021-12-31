<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiLeafe
 * 
 * @property int $webhookEventId
 * 
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 *
 * @package App\Models
 */
class MessagingApiLeafe extends Model
{
	protected $table = 'messaging_api_leaves';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'webhookEventId' => 'int'
	];

	protected $fillable = [
		'webhookEventId'
	];

	public function messaging_api_webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}
}
