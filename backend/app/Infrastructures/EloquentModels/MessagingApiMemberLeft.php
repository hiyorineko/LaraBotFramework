<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMemberLeft
 *
 * @property int $webhookEventId
 * @property array $members
 * @property string $replyToken
 *
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 *
 * @package App\Models
 */
class MessagingApiMemberLeft extends Model
{
	protected $table = 'messaging_api_member_lefts';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'webhookEventId' => 'int',
		'members' => 'json'
	];

	protected $fillable = [
		'webhookEventId',
		'members',
		'replyToken'
	];

	public function webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}
}
