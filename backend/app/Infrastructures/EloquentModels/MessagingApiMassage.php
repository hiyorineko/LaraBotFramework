<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassage
 *
 * @property int $id
 * @property int $webhookEventId
 * @property string $replyToken
 *
 * @property MessagingApiWebhookEvent $messaging_api_webhook_event
 * @property MessagingApiMassageAudio $messaging_api_massage_audio
 * @property MessagingApiMassageFile $messaging_api_massage_file
 * @property MessagingApiMassageImage $messaging_api_massage_images
 * @property MessagingApiMassageLocation $messaging_api_massage_location
 * @property MessagingApiMassageSticker $messaging_api_massage_stamp
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
		'webhookEventId' => 'int'
	];

	protected $fillable = [
		'webhookEventId',
		'replyToken'
	];

	public function webhook_event()
	{
		return $this->belongsTo(MessagingApiWebhookEvent::class, 'webhookEventId');
	}

	public function massage_audio()
	{
		return $this->hasOne(MessagingApiMassageAudio::class, 'message_id');
	}

	public function massage_file()
	{
		return $this->hasOne(MessagingApiMassageFile::class, 'message_id');
	}

	public function massage_image()
	{
		return $this->hasOne(MessagingApiMassageImage::class, 'message_id');
	}

	public function massage_location()
	{
		return $this->hasOne(MessagingApiMassageLocation::class, 'message_id');
	}

	public function massage_stamp()
	{
		return $this->hasOne(MessagingApiMassageSticker::class, 'message_id');
	}

	public function massage_text()
	{
		return $this->hasOne(MessagingApiMassageText::class, 'message_id');
	}

	public function massage_video()
	{
		return $this->hasOne(MessagingApiMassageVideo::class, 'message_id');
	}
}
