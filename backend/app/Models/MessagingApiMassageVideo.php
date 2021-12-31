<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageVideo
 * 
 * @property int $message_id
 * @property int $duration
 * @property string $type
 * @property string $original_content_url
 * @property string $preview_image_url
 * @property string $file_name
 * @property string $path
 * 
 * @property MessagingApiMassage $messaging_api_massage
 *
 * @package App\Models
 */
class MessagingApiMassageVideo extends Model
{
	protected $table = 'messaging_api_massage_videos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'message_id' => 'int',
		'duration' => 'int'
	];

	protected $fillable = [
		'message_id',
		'duration',
		'type',
		'original_content_url',
		'preview_image_url',
		'file_name',
		'path'
	];

	public function messaging_api_massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'message_id');
	}
}
