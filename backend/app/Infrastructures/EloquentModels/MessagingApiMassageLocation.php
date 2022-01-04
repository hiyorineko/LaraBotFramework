<?php

/**
 * Created by Reliese Model.
 */

namespace App\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageLocation
 *
 * @property int $messageId
 * @property string $title
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 *
 * @property MessagingApiMassage $messaging_api_massage
 *
 * @package App\Models
 */
class MessagingApiMassageLocation extends Model
{
	protected $table = 'messaging_api_massage_locations';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'messageId' => 'int',
		'latitude' => 'float',
		'longitude' => 'float'
	];

	protected $fillable = [
		'messageId',
		'title',
		'address',
		'latitude',
		'longitude'
	];

	public function massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'messageId');
	}
}
