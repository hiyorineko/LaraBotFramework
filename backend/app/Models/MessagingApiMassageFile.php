<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageFile
 * 
 * @property int $message_id
 * @property int $file_size
 * @property string $file_name
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
		'message_id' => 'int',
		'file_size' => 'int'
	];

	protected $fillable = [
		'message_id',
		'file_size',
		'file_name',
		'path'
	];

	public function messaging_api_massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'message_id');
	}
}
