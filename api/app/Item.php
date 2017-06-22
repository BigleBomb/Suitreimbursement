<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {
	
	protected $table = 'item';

    protected $fillable = [
		'reimburse_id', 'date', 'category', 'cost', 'picture'
	];

	public function reimburse(){
		return $this->belongsTo('App\Reimburse', 'reimburse_id');
	}
}
