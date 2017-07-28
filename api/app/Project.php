<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
	
	protected $table = 'project';

    protected $fillable = [
		'project_name', 'category', 'total_cost', 'details'
	];

	public function user(){
		return $this->belongsToMany('App\User', 'project_user_list', 'project_id', 'user_id');
	}

	public function reimburse(){
		return $this->hasMany('App\Reimburse');
	}
}
