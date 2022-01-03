<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageImage
 *
 * @property int $messageId
 * @property string $image_set_id
 * @property int $imageSetIndex
 * @property int $imageSetTotal
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
	protected $table = 'messaging_api_massage_images';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'messageId' => 'int',
		'imageSetIndex' => 'int',
		'imageSetTotal' => 'int'
	];

	protected $fillable = [
		'messageId',
        'imageSetId',
		'imageSetIndex',
		'imageSetTotal',
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
