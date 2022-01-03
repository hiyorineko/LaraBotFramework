<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageAudio
 *
 * @property int $messageId
 * @property int $duration
 * @property string $type
 * @property string $originalContentUrl
 * @property string $previewImageUrl
 * @property string $fileName
 * @property string $path
 *
 * @property MessagingApiMassage $messaging_api_massage
 *
 * @package App\Models
 */
class MessagingApiMassageAudio extends Model
{
	protected $table = 'messaging_api_massage_audios';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'messageId' => 'int',
		'duration' => 'int'
	];

	protected $fillable = [
		'messageId',
		'duration',
		'type',
		'originalContentUrl',
		'previewImageUrl',
		'fileName',
		'path'
	];

	public function messaging_api_massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'messageId');
	}
}
