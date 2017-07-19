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
			$res['result'][$i]['user_count'] = $user;
			$i++;
		}
		return response($res);
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
			$user = User::find($userdata->user()->first()->id);
			$res['result'][$i]['user_data'] = $user;
			$i++;
		}
		return response($res);
	}
	
	public function create(Request $request)
	{
		$user_id = $request->input('user_id');
		$date = $request->input('date');
		$project_name = $request->input('project_name');
		$total_cost = $request->input('total_cost');
		$details = $request->input('details');

		$user = User::where('id', $user_id)->first();
		if($user){
			$project = Project::create([
				'user_id' => $user_id,
				'date' => $date,
				'project_name' => $project_name,
				'details' => $details,
				'status' => 0,
				'reason' => ''
			]);

			if($project){
				$res['success'] = true;
				$res['message'] = 'Success adding new projectment';

			}else{
				$res['success'] = false;
				$res['message'] = 'Failed adding new projectment';

				return response($res);
			}

			$re = Project::where('id', $project->id)->first();
			$id = $re->id;
			$reimburse = Item::where('project_id', $id)->get();
			$totalcost = 0;
			foreach($reimburse as $itemdata){
				$totalcost += $itemdata->cost;
			}
			$re->totalcost = $totalcost;
			$re->save();
			if($re !=null ){
				if($file->isValid()){
					$filename = "projectPic".$id.".".$file->getClientOriginalExtension();
					$re->foto = $filename;
					$re->save();
					$destinationPath = "../../cms/images/u$user_id/";
					$file->move($destinationPath,$filename);

					$res['file'] = "Uploaded successfully";

					return response($res);
				}
				else{
					$res['file'] = "No file attached";
					return response($res);
				}
			}
		}
		else
		{
			$res['success'] = false;
			$res['message'] = 'Invalid user id';
			
			return response($res);
		}
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

	public function get_project(Request $request, $id){
		$project = Project::where('id', $id)->first();
		if($project !== null){
			$project = Project::find($id);
			$user = $project->user()->get();
			$reimburse = $project->reimburse()->get();
			$res['success'] = true;
			$res['result'] = $project;
			$res['result']['user_data'] = $user;
			$res['result']['reimburse_data'] = $reimburse;
			$user_count=0;
			foreach($user as $user_data){
				$users = User::where('id', $user_data->id)->count();
				if($users){
					$user_count++;
				}
			}
			$i=0;
			foreach($reimburse as $user_data){
				$user_reimburse = User::where('id', $user_data->user_id)->first();
				$res['result']['reimburse_data'][$i]['userid'] = $user_reimburse->id;
				$res['result']['reimburse_data'][$i]['user_name'] = $user_reimburse->nama;
				$i++;
			}
			$res['result']['user_count'] = $user_count;

			return response($res);
		}else{
			$res['success'] = false;
			$res['message'] = 'Project with id ' . $id . ' not found';

			return response($res);
		}
	}

	public function accept(Request $request, $id)
	{
		$reason = "";
		if($request->has('reason'))
			$reason = $request->input('reason');
		$project = Project::find($id);
		if($project){
			if($project->status != 1){
				$project->status = 1;
				$project->reason = $reason;
				if($project->save()){
					$res['success'] = true;
					$res['message'] = "Project ID ".$id." has been accepted.";

					return response($res);
				}else{
					$res['succes'] = false;
					$res['message'] = "Error in saving the query";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "Project ID ".$id." is already accepted.";

				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "Could not find project data with id ".$id;

			return response($res);
		}
	}

	public function reject(Request $request, $id)
	{
		$reason = "";
		if($request->has('reason'))
			$reason = $request->input('reason');
		$project = Project::find($id);
		if($project){
			if($project->status != 2){
				$project->status = 2;
				$project->reason = $reason;
				if($project->save()){
					$res['success'] = true;
					$res['message'] = "Project ID ".$id." has been rejected.";

					return response($res);
				}else{
					$res['succes'] = false;
					$res['message'] = "Error in saving the query";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "Project ID ".$id." is already rejected.";

				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "Could not find project data with id ".$id;

			return response($res);
		}
	}
	
	public function update(Request $request, $menu, $id)
	{
		if($request->has(''))
		if($request->has('name')){
			$project = Project::find($id);
			$project->name = $request->input('name');
			if($project->save()){
				$res['success'] = true;
				$res['message'] = 'Success update '.$request->input('name');

				return response($res);
			}
		}else{
			$res['success'] = false;
			$res['message'] = 'Please fill name Project';
			return response($res);
		}
	}

	public function delete(Request $request, $id){
		$project = Project::find($id);
		if($project->delete($id)){
			$res['success'] = true;
			$res['message'] = "Success deleting Project with id ".$id;

			return response($res);
		}
	}
}
