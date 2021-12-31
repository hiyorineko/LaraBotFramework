<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessagingApiMassageLocation
 * 
 * @property int $message_id
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
		'message_id' => 'int',
		'latitude' => 'float',
		'longitude' => 'float'
	];

	protected $fillable = [
		'message_id',
		'title',
		'address',
		'latitude',
		'longitude'
	];

	public function messaging_api_massage()
	{
		return $this->belongsTo(MessagingApiMassage::class, 'message_id');
	}
}
