<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageText
 *
 * @property int $messageId
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
		'messageId' => 'int',
		'emojis' => 'json',
		'mentions' => 'json'
	];

	protected $fillable = [
		'messageId',
		'text',
		'emojis',
		'mentions'
	];

	public function messaging_api_massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'messageId');
	}
}
