<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiUnsend
 * 
 * @property int $webhookEventId
 * @property int $messageId
 * 
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 *
 * @package App\Models
 */
class MessagingApiUnsend extends Model
{
	protected $table = 'messaging_api_unsends';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'webhookEventId' => 'int',
		'messageId' => 'int'
	];

	protected $fillable = [
		'webhookEventId',
		'messageId'
	];

	public function messaging_api_webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}
}
