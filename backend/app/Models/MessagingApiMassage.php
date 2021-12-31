<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassage
 * 
 * @property int $id
 * @property int $webhook_event_id
 * @property string $replyToken
 * 
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 * @property MessagingApiMassageAudio $messaging_api_massage_audio
 * @property MessagingApiMassageFile $messaging_api_massage_file
 * @property Collection|MessagingApiMassageImage[] $messaging_api_massage_images
 * @property MessagingApiMassageLocation $messaging_api_massage_location
 * @property MessagingApiMassageStamp $messaging_api_massage_stamp
 * @property MessagingApiMassageText $messaging_api_massage_text
 * @property MessagingApiMassageVideo $messaging_api_massage_video
 *
 * @package App\Models
 */
class MessagingApiMassage extends Model
{
	protected $table = 'messaging_api_massages';
	public $timestamps = false;

	protected $casts = [
		'webhook_event_id' => 'int'
	];

	protected $fillable = [
		'webhook_event_id',
		'replyToken'
	];

	public function messaging_api_webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhook_event_id');
	}

	public function messaging_api_massage_audio()
	{
		return $this->hasOne(MessagingApiMassageAudio::class, 'message_id');
	}

	public function messaging_api_massage_file()
	{
		return $this->hasOne(MessagingApiMassageFile::class, 'message_id');
	}

	public function messaging_api_massage_images()
	{
		return $this->hasMany(MessagingApiMassageImage::class, 'message_id');
	}

	public function messaging_api_massage_location()
	{
		return $this->hasOne(MessagingApiMassageLocation::class, 'message_id');
	}

	public function messaging_api_massage_stamp()
	{
		return $this->hasOne(MessagingApiMassageStamp::class, 'message_id');
	}

	public function messaging_api_massage_text()
	{
		return $this->hasOne(MessagingApiMassageText::class, 'message_id');
	}

	public function messaging_api_massage_video()
	{
		return $this->hasOne(MessagingApiMassageVideo::class, 'message_id');
	}
}
