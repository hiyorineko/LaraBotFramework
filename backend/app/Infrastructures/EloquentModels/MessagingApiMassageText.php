<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageText
 *
 * @property int $messageId
 * @property string $text
 * @property array $emojis
 * @property array $mention
 *
 * @property MessagingApiMassage $messaging_api_massage
 *
 * @package App\Models
 */
class MessagingApiMassageText extends Model
{
	protected $table = 'messaging_api_massage_texts';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'messageId' => 'int',
		'emojis' => 'json',
		'mention' => 'json'
	];

	protected $fillable = [
		'messageId',
		'text',
		'emojis',
		'mention'
	];

	public function massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'messageId');
	}
}
