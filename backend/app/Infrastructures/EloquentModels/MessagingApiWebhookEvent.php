<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiWebhookEvent
 *
 * @property int $id
 * @property string $destination
 * @property string $mode
 * @property string $sourceType
 * @property string $userId
 * @property string $groupId
 * @property string $roomId
 * @property int $timestamp
 *
 * @property MessagingApiAccountLink $account_link
 * @property MessagingApiBeacon $beacon
 * @property MessagingApiFollow $follow
 * @property MessagingApiJoin $join
 * @property MessagingApiLeave $leave
 * @property MessagingApiLink $link
 * @property Collection|MessagingApiMassage[] $massages
 * @property MessagingApiMemberJoined $member_joined
 * @property MessagingApiMemberLeft $member_left
 * @property MessagingApiPostback $postback
 * @property MessagingApiThingsLink $things_link
 * @property MessagingApiThingsScenarioResult $things_scenario_result
 * @property MessagingApiThingsUnlink $things_unlink
 * @property MessagingApiUnfollow $unfollow
 * @property MessagingApiUnsend $unsend
 * @property MessagingApiVideoPlayComplete $video_play_complete
 *
 * @package App\Models
 */
class MessagingApiWebhookEvent extends Model
{
	protected $table = 'messaging_api_webhook_events';
	public $timestamps = false;

	protected $fillable = [
		'destination',
		'mode',
		'sourceType',
		'userId',
		'groupId',
		'roomId',
        'timestamp'
	];

	public function account_link()
	{
		return $this->hasOne(MessagingApiAccountLink::class, 'webhookEventId');
	}

	public function beacon()
	{
		return $this->hasOne(MessagingApiBeacon::class, 'webhookEventId');
	}

	public function follow()
	{
		return $this->hasOne(MessagingApiFollow::class, 'webhookEventId');
	}

	public function join()
	{
		return $this->hasOne(MessagingApiJoin::class, 'webhookEventId');
	}

	public function leave()
	{
		return $this->hasOne(MessagingApiLeave::class, 'webhookEventId');
	}

	public function link()
	{
		return $this->hasOne(MessagingApiLink::class, 'webhookEventId');
	}

	public function massages()
	{
		return $this->hasMany(MessagingApiMassage::class, 'webhook_event_id');
	}

	public function member_joined()
	{
		return $this->hasOne(MessagingApiMemberJoined::class, 'webhookEventId');
	}

	public function member_left()
	{
		return $this->hasOne(MessagingApiMemberLeft::class, 'webhookEventId');
	}

	public function postback()
	{
		return $this->hasOne(MessagingApiPostback::class, 'webhookEventId');
	}

	public function things_link()
	{
		return $this->hasOne(MessagingApiThingsLink::class, 'webhookEventId');
	}

	public function things_scenario_result()
	{
		return $this->hasOne(MessagingApiThingsScenarioResult::class, 'webhookEventId');
	}

	public function things_unlink()
	{
		return $this->hasOne(MessagingApiThingsUnlink::class, 'webhookEventId');
	}

	public function unfollow()
	{
		return $this->hasOne(MessagingApiUnfollow::class, 'webhookEventId');
	}

	public function unsend()
	{
		return $this->hasOne(MessagingApiUnsend::class, 'webhookEventId');
	}

	public function video_play_complete()
	{
		return $this->hasOne(MessagingApiVideoPlayComplete::class, 'webhookEventId');
	}
}
