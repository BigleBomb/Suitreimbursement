<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reimburse extends Model {
	
	protected $table = 'reimburse';

    protected $fillable = [
		'user_id', 'project_id', 'date', 'category', 'cost', 'picture', 'status', 'reason'
	];

	public function project(){
		return $this->belongsTo('App\Project', 'project_id');
	}

	public function user(){
		return $this->belongsTo('App\User', 'user_id');
	}
}
