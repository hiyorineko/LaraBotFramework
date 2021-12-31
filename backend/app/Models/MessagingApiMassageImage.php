<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageImage
 * 
 * @property int $message_id
 * @property string $image_set_id
 * @property int $image_set_index
 * @property int $image_set_total
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
class MessagingApiMassageImage extends Model
{
	protected $table = 'messaging_api_massage_image';
	protected $primaryKey = 'image_set_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'message_id' => 'int',
		'image_set_index' => 'int',
		'image_set_total' => 'int'
	];

	protected $fillable = [
		'message_id',
		'image_set_index',
		'image_set_total',
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
