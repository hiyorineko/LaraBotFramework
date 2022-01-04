<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiLeave
 *
 * @property int $webhookEventId
 *
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 *
 * @package App\Models
 */
class MessagingApiLeave extends Model
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

	public function webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}
}
