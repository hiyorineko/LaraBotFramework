<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiWebhookEvent
 * 
 * @property int $id
 * @property string $destination
 * @property string $mode
 * @property string $source_type
 * @property string $user_id
 * @property string $group_id
 * @property string $room_id
 * @property Carbon $created_at
 * 
 * @property MessagingApiAccountLink $messaging_api_account_link
 * @property MessagingApiBeacon $messaging_api_beacon
 * @property MessagingApiFollow $messaging_api_follow
 * @property MessagingApiJoin $messaging_api_join
 * @property MessagingApiLeafe $messaging_api_leafe
 * @property MessagingApiLink $messaging_api_link
 * @property Collection|MessagingApiMassage[] $messaging_api_massages
 * @property MessagingApiMemberJoined $messaging_api_member_joined
 * @property MessagingApiMemberLeft $messaging_api_member_left
 * @property MessagingApiPostback $messaging_api_postback
 * @property MessagingApiThingsLink $messaging_api_things_link
 * @property MessagingApiThingsScenarioResult $messaging_api_things_scenario_result
 * @property MessagingApiThingsUnlink $messaging_api_things_unlink
 * @property MessagingApiUnfollow $messaging_api_unfollow
 * @property MessagingApiUnsend $messaging_api_unsend
 * @property MessagingApiVideoPlayComplete $messaging_api_video_play_complete
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
		'source_type',
		'user_id',
		'group_id',
		'room_id'
	];

	public function messaging_api_account_link()
	{
		return $this->hasOne(MessagingApiAccountLink::class, 'webhookEventId');
	}

	public function messaging_api_beacon()
	{
		return $this->hasOne(MessagingApiBeacon::class, 'webhookEventId');
	}

	public function messaging_api_follow()
	{
		return $this->hasOne(MessagingApiFollow::class, 'webhookEventId');
	}

	public function messaging_api_join()
	{
		return $this->hasOne(MessagingApiJoin::class, 'webhookEventId');
	}

	public function messaging_api_leafe()
	{
		return $this->hasOne(MessagingApiLeafe::class, 'webhookEventId');
	}

	public function messaging_api_link()
	{
		return $this->hasOne(MessagingApiLink::class, 'webhookEventId');
	}

	public function messaging_api_massages()
	{
		return $this->hasMany(MessagingApiMassage::class, 'webhook_event_id');
	}

	public function messaging_api_member_joined()
	{
		return $this->hasOne(MessagingApiMemberJoined::class, 'webhookEventId');
	}

	public function messaging_api_member_left()
	{
		return $this->hasOne(MessagingApiMemberLeft::class, 'webhookEventId');
	}

	public function messaging_api_postback()
	{
		return $this->hasOne(MessagingApiPostback::class, 'webhookEventId');
	}

	public function messaging_api_things_link()
	{
		return $this->hasOne(MessagingApiThingsLink::class, 'webhookEventId');
	}

	public function messaging_api_things_scenario_result()
	{
		return $this->hasOne(MessagingApiThingsScenarioResult::class, 'webhookEventId');
	}

	public function messaging_api_things_unlink()
	{
		return $this->hasOne(MessagingApiThingsUnlink::class, 'webhookEventId');
	}

	public function messaging_api_unfollow()
	{
		return $this->hasOne(MessagingApiUnfollow::class, 'webhookEventId');
	}

	public function messaging_api_unsend()
	{
		return $this->hasOne(MessagingApiUnsend::class, 'webhookEventId');
	}

	public function messaging_api_video_play_complete()
	{
		return $this->hasOne(MessagingApiVideoPlayComplete::class, 'webhookEventId');
	}
}
