<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageFile
 *
 * @property int $messageId
 * @property int $fileSize
 * @property string $fileName
 * @property string $path
 *
 * @property MessagingApiMassage $messaging_api_massage
 *
 * @package App\Models
 */
class MessagingApiMassageFile extends Model
{
	protected $table = 'messaging_api_massage_files';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'messageId' => 'int',
		'fileSize' => 'int'
	];

	protected $fillable = [
		'messageId',
		'fileSize',
		'fileName',
		'path'
	];

	public function messaging_api_massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'messageId');
	}
}
