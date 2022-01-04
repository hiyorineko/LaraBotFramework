<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageSticker
 *
 * @property int $messageId
 * @property string $packageId
 * @property string $stickerId
 * @property string $stickerResourceType
 * @property array $keywords
 * @property string $text
 *
 * @property MessagingApiMassage $messaging_api_massage
 *
 * @package App\Models
 */
class MessagingApiMassageSticker extends Model
{
	protected $table = 'messaging_api_massage_stickers';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'messageId' => 'int',
		'keywords' => 'json'
	];

	protected $fillable = [
		'messageId',
		'packageId',
		'stickerId',
		'stickerResourceType',
		'keywords',
		'text'
	];

	public function massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'messageId');
	}
}
