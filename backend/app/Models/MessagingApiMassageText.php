<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageText
 * 
 * @property int $message_id
 * @property string $text
 * @property array $emojis
 * @property array $mentions
 * 
 * @property MessagingApiMassage $messaging_api_massage
 *
 * @package App\Models
 */
class MessagingApiMassageText extends Model
{
	protected $table = 'messaging_api_massage_text';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'message_id' => 'int',
		'emojis' => 'json',
		'mentions' => 'json'
	];

	protected $fillable = [
		'message_id',
		'text',
		'emojis',
		'mentions'
	];

	public function messaging_api_massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'message_id');
	}
}
