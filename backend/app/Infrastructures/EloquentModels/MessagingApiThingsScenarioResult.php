<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiThingsScenarioResult
 *
 * @property int $webhookEventId
 * @property string $replyToken
 * @property string $thingsDeviceId
 * @property string $thingsResultScenarioId
 * @property int $thingsResultRevision
 * @property int $thingsResultStartTime
 * @property int $thingsResultEndTime
 * @property string $thingsResultResultCode
 * @property array $thingsResultActionResults
 * @property string $thingsResultBleNotificationPayload
 * @property string $thingsResultErrorReason
 *
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 *
 * @package App\Models
 */
class MessagingApiThingsScenarioResult extends Model
{
	protected $table = 'messaging_api_things_scenario_results';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'webhookEventId' => 'int',
		'thingsResultRevision' => 'int',
        'thingsResultStartTime' => 'int',
        'thingsResultEndTime' => 'int',
		'thingsResultActionResults' => 'json'
	];

	protected $fillable = [
		'webhookEventId',
		'replyToken',
		'thingsDeviceId',
		'thingsResultScenarioId',
		'thingsResultRevision',
		'thingsResultStartTime',
		'thingsResultEndTime',
		'thingsResultResultCode',
		'thingsResultActionResults',
		'thingsResultBleNotificationPayload',
		'thingsResultErrorReason'
	];

	public function webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}
}
