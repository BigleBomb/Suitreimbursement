<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reimburse extends Model {
	
	protected $table = 'reimburse';

    protected $fillable = [
		'user_id', 'date', 'project_name', 'category', 'total_cost', 'detail', 'status', 'reason'
	];

	public function user(){
		return $this->belongsTo('App\User', 'user_id');
	}

	public function item(){
		return $this->hasMany('App\Item');
	}
}
