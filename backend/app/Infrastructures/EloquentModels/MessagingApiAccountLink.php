<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiAccountLink
 *
 * @property int $webhookEventId
 * @property string $replyToken
 * @property array $link
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
		'link' => 'json'
	];

	protected $fillable = [
		'webhookEventId',
		'replyToken',
		'link'
	];

	public function webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}
}
