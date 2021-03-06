<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiBeacon
 *
 * @property int $webhookEventId
 * @property string $replyToken
 * @property string $beaconHwid
 * @property string $beaconType
 * @property string $beaconDm
 *
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 *
 * @package App\Models
 */
class MessagingApiBeacon extends Model
{
	protected $table = 'messaging_api_beacons';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'webhookEventId' => 'int'
	];

	protected $fillable = [
		'webhookEventId',
		'replyToken',
		'beaconHwid',
		'beaconType',
		'beaconDm'
	];

	public function webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}
}
