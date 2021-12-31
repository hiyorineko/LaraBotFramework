<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageStamp
 * 
 * @property int $message_id
 * @property string $package_id
 * @property string $sticker_id
 * @property string $sticker_resource_type
 * @property array $keywords
 * @property string $text
 * 
 * @property MessagingApiMassage $messaging_api_massage
 *
 * @package App\Models
 */
class MessagingApiMassageStamp extends Model
{
	protected $table = 'messaging_api_massage_stamps';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'message_id' => 'int',
		'keywords' => 'json'
	];

	protected $fillable = [
		'message_id',
		'package_id',
		'sticker_id',
		'sticker_resource_type',
		'keywords',
		'text'
	];

	public function messaging_api_massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'message_id');
	}
}
