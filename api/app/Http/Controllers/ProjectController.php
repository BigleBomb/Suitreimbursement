<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Project;
use App\User;

class ProjectController extends Controller {
	
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
		$project = Project::all();

		$res['success'] = true;
		$res['result'] = $project;
		$i=0;
		foreach($project as $project_data){
			$user = Project::find($project_data->id)->user()->count();
			$reimburse = Project::find($project_data->id)->reimburse()->count();
			$res['result'][$i]['user_count'] = $user;
			$res['result'][$i]['reimburse_count'] = $reimburse;
			$i++;
		}
		return response($res);
	}

	public function get_unchecked($pid){
		$project = Project::find($pid);
		if($project){
			$reimburse = $project->reimburse()->where('checked', 0)->count();
			$res['success'] = true;
			$res['result'] = $reimburse;
			return response($res);
		}
		else{
			$res['success'] = false;
			$res['result'] = "No project with ID $pid found";
			return response($res);
		}
	}

	public function get_user_list(Request $request, $id){
		$project = Project::find($id)->user()->get();

		$res['success'] = true;
		$res['result'] = $project;

		return response($res);
	}

	public function get_user_count(Request $request, $id){
		$project = Project::find($id)->user()->count();

		$res['success'] = true;
		$res['result'] = $project;

		return response($res);
	}

	public function get_last(Request $request, $amount)
	{
		$project = Project::orderBy('id', 'desc')->take($amount)->get();

		$res['success'] = true;
		$res['result'] = $project;
		$i=0;
		foreach($project as $userdata)
		{
			$user = $userdata->user()->get();
			$res['result'][$i]['user_data'] = $user;
			$i++;
		}
		return response($res);
	}

	public function get_available_user($pid){
		$project = Project::find($pid);
		if($project){
			$users = $project->user()->get();
			$user = User::all();
			$user = $user->keyBy('id');
			foreach($users as $userlist){
				$user->forget($userlist->id);
			}
			$user = $user->values();
			if($user->count() == 0){
				$res['success'] = false;
				$res['message'] = "No available user for this project";

				return response($res);
			}
			else{
				$res['success'] = true;
				$res['result'] = $user;
				
				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "No project with ID $pid found";

			return response($res);
		}
	}

	public function delete_user(Request $request){
		$pid = $request->project_id;
		$uid = $request->user_id;
		if($pid || $uid != null){
			$project = Project::find($pid);
			if($project){
				if($project->user()->find($uid)!=false){
					$user = User::find($uid);
					if($user){
						$project_user = $project->user()->detach($user);
						$res['success'] = true;
						$res['message'] = "Success deleting User ID $uid from Project ID $pid";

						return response($res);
					}
					else{
						$res['success'] = false;
						$res['message'] = "User ID $uid is not found";

						return response($res);
					}
				}
				else{
					$res['success'] = false;
					$res['message'] = "User ID $uid is already not in this project";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "Project ID $uid is not found";

				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "User ID or Project ID cannot be empty";

			return response($res);
		}

	}

	public function add_user(Request $request){
		$pid = $request->project_id;
		$uid = $request->user_id;
		if($pid || $uid != null){
			$project = Project::find($pid);
			if($project){
				if($project->user()->find($uid)!=true){
					$user = User::find($uid);
					if($user){
						$project_user = $project->user()->attach($user);
						$res['success'] = true;
						$res['message'] = "Success adding User ID $uid to Project ID $pid";

						return response($res);
					}
					else{
						$res['success'] = false;
						$res['message'] = "User ID $uid is not found";

						return response($res);
					}
				}
				else{
					$res['success'] = false;
					$res['message'] = "User ID $uid is already in this project";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "Project ID $uid is not found";

				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "User ID or Project ID cannot be empty";

			return response($res);
		}

	}
	
	public function create(Request $request)
	{
		$date = $request->input('date');
		$project_name = $request->input('project_name');
		$details = $request->input('details');

		$project = Project::create([
			'date' => $date,
			'project_name' => $project_name,
			'details' => $details,
		]);

		if($project){
			$res['success'] = true;
			$res['message'] = 'Success adding new project';

		}else{
			$res['success'] = false;
			$res['message'] = 'Failed adding new project';

			return response($res);
		}

		return response($res);
	}

	public function get_latest(Request $request){
		$project = Project::orderBy('created_at', 'desc')->first();
		if($project != null){
			$res['success'] = true;
			$res['result'] = $project;

			return response($res);
		}
		else{
			$res['success'] = false;
			$res['message'] = "Failed to get project data";

			return response($res);
		}
	}

	public function get_pending(Request $request, $menu){
		if($menu === 'totalcount'){
			$project = Project::where('status', 0)->get();
			if($project){
				if($project->count() > 0){						
					$res['success'] = true;
					$res['result']['count'] = $project->count();

					return response($res);
				}else{
					$res['success'] = false;
					$res['message'] = "No pending projectments";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "Failed to get the count";

				return response($res);
			}	
		}
		else if($menu === 'totalamount'){
			$project = Project::all();
			if($project !== null){
				$pend = 0;
				foreach($project as $reimdata)
				{
					if($reimdata->status == 0)
						$pend += $reimdata->total_cost;
					else{}
				}
				if($pend > 0){
					$res['success'] = true;
					$res['result']['amount'] = $pend;

					return response($res);
				}
				else{
					$res['success'] = false;
					$res['message'] = "No pending amount";

					return response($res);
				}
			}else{
				$res['success'] = false;
				$res['message'] = "Failed to get the pending amount";

				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "Invalid menu";

			return response($res);
		}
	}

	public function get_project_by_userid($id){
		$user = User::find($id);
		if($user){
			$project = $user->project()->get();
			if($project){
				$res['success'] = true;
				$res['result'] = $project;

				return response($res);
			}
			else{
				$res['success'] = false;
				$res['message'] = "No project is associated with this user";

				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "No user with ID $id found";

			return response($res);
		}
	}

	public function get_project($id){
		$project = Project::where('id', $id)->first();
		if($project){
			$project = Project::find($id);
			$user = $project->user()->get();
			$reimburse = $project->reimburse()->get();
			$res['success'] = true;
			$res['result'] = $project;
			$user = $user->keyBy('id');
			$user = $user->sortBy('id');
			$user = $user->values();
			$res['result']['user_data'] = $user;
			$res['result']['reimburse_data'] = $reimburse;
			$user_count=$project->user()->count();;
			$reimburse_count=$project->reimburse()->count();
			$i=0;
			foreach($reimburse as $user_data){
				$user_reimburse = User::where('id', $user_data->user_id)->first();
				$res['result']['reimburse_data'][$i]['userid'] = $user_reimburse->id;
				$res['result']['reimburse_data'][$i]['user_name'] = $user_reimburse->nama;
				$i++;
			}
			$res['result']['user_count'] = $user_count;
			$res['result']['reimburse_count'] = $reimburse_count;

			return response($res);
		}else{
			$res['success'] = false;
			$res['message'] = 'Project with id ' . $id . ' not found';

			return response($res);
		}
	}

	public function get_reimburse_list($id, $menu){
		if($menu == 'pending'){
			$project = Project::find($id);
			$reimburse = $project->reimburse()->where('status', 0)->get();
			if($reimburse != null){
				if($reimburse->count() > 0){
					$res['success'] = true;
					$res['result'] = $reimburse;
					$i=0;
					foreach($reimburse as $userdata)
					{
						$user = User::find($userdata->user()->first()->id);
						$res['result'][$i]['user_name'] = $user->nama;
						$i++;
					}

					return response($res);
				}
				else{
					$res['success'] = false;
					$res['message'] = "No pending reimbursements";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "No project with ID $id";

				return response($res);
			}
		}
		else if($menu == 'accepted'){
			$project = Project::find($id);

			$reimburse = $project->reimburse()->where('status', 1)->get();
			if($reimburse != null){
				if($reimburse->count() > 0){
					$res['success'] = true;
					$res['result'] = $reimburse;
					$i=0;
					foreach($reimburse as $userdata)
					{
						$user = User::find($userdata->user()->first()->id);
						$res['result'][$i]['user_name'] = $user->nama;
						$i++;
					}

					return response($res);
					}else{
					$res['success'] = false;
					$res['message'] = "No accepted reimbursements";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "No project with ID $id";

				return response($res);
			}
		}
		else if($menu == 'rejected'){
			$project = Project::find($id);

			$reimburse = $project->reimburse()->where('status', 2)->get();
			if($reimburse != null){
				if($reimburse->count() > 0){
					$res['success'] = true;
					$res['result'] = $reimburse;
					$i=0;
					foreach($reimburse as $userdata)
					{
						$user = User::find($userdata->user()->first()->id);
						$res['result'][$i]['user_name'] = $user->nama;
						$i++;
					}

					return response($res);
					}else{
					$res['success'] = false;
					$res['message'] = "No rejected reimbursements";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "No project with ID $id";

				return response($res);
			}
		}
	}
	
	public function update_cost($pid)
	{
		$project = Project::find($pid);
		if($project){
			$reimburse = $project->reimburse()->get();
			$totalcost = 0;
			foreach($reimburse as $reimburse_data){
				$totalcost += $reimburse_data->cost;
			}
			$project->total_cost = $totalcost;
			$project->save();
			$res['success'] = true;
			$res['message'] = "Success updating the total cost of Project ID $pid";
			return $res;
		}
		else{
			$res['success'] = false;
			$res['message'] = "Failed updating the total cost of Project ID $pid";
			return $res;
		}
	}

	public function delete($id){
		$project = Project::find($id);
		if($project->delete($id)){
			$res['success'] = true;
			$res['message'] = "Success deleting Project with id ".$id;

			return response($res);
		}
	}

	public function update(Request $request, $pid){
		$project = Project::find($pid);
		if($project){
			$name = $request->project_name;
			$details = $request->project_details;

			$project->project_name = $name;
			$project->details = $details;

			if($project->save()){
				$res['success'] = true;
				$res['message'] = "Success updating Project ID $pid";

				return response($res);
			}else{
				$res['success'] = false;
				$res['message'] = "Failed updating Project ID $pid";

				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "No project with ID $pid found";

			return response($res);
		}
	}
}
