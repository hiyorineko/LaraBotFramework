<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiPostback
 *
 * @property int $webhookEventId
 * @property string $data
 * @property array $params
 * @property string $replyToken
 *
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 *
 * @package App\Models
 */
class MessagingApiPostback extends Model
{
	protected $table = 'messaging_api_postbacks';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'webhookEventId' => 'int',
		'params' => 'json'
	];

	protected $fillable = [
		'webhookEventId',
		'data',
		'params',
		'replyToken'
	];

	public function messaging_api_webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}
}
