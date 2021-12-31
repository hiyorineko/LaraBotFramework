<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiAccountLink
 * 
 * @property int $webhookEventId
 * @property string $replyToken
 * @property array $links
 * 
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 *
 * @package App\Models
 */
class MessagingApiAccountLink extends Model
{
	protected $table = 'messaging_api_account_links';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'webhookEventId' => 'int',
		'links' => 'json'
	];

	protected $fillable = [
		'webhookEventId',
		'replyToken',
		'links'
	];

	public function messaging_api_webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}
}
