<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Project;
use App\Reimburse;
use App\User;

class ReimburseController extends Controller {
	
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function get(Request $request, $id)
	{
		$reimburse = Reimburse::where('reimburse_id', $id)->get();

		if($reimburse->count() > 0){
			$res['success'] = true;
			$res['result'] = $reimburse;
			return response($res);
		}
		else{
			$res['success'] = false;
			$res['message'] = "No reimburse for this Project ID";
			return response($res);
		}
	}

	public function get_reimburse(Request $request, $id){
		$reimburse = Reimburse::find($id);

		if($reimburse){
			$user = $reimburse->user()->first();
			$project = $reimburse->project()->first();
			$res['success'] = true;
			$res['result'] = $reimburse;
			$res['result']['user_data'] = $user;
			$res['result']['project_data'] = $project;
			$image = app('App\Http\Controllers\ReimburseController')->getImagePath($project->id, $reimburse->id);
			$res['result']['image'] ="";
			if($image != "null"){
				$fileData = file_get_contents($image);
				$res['result']['image'] = base64_encode($fileData);

				return response($res);
			}
			else{
				$res['result']['image'] = "None";
				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "No reimburse for this ID";
			return response($res);
		}

	}

	public function get_last(Request $request, $count)
	{
		$reimburse = Reimburse::orderBy('id', 'desc')->take($count)->get();

		$res['success'] = true;
		$res['result'] = $reimburse;
		$i=0;
		foreach($reimburse as $reimbursedata)
		{
			$reimburse = Project::find($reimbursedata->project()->first()->id);
			$user = User::find($reimbursedata->user()->first()->id);
			$res['result'][$i]['project_name'] = $reimburse->project_name;
			$res['result'][$i]['user_name'] = $user->nama;
			$i++;
		}
		return response($res);
	}

	public function get_total($menu){
		if($menu == "amount"){
			$reimburse = Reimburse::all()->where('status', 1);
			$total = 0;
			foreach($reimburse as $reimburselist){
				$total += $reimburselist->cost;
			}
			$res['success'] = true;
			$res['result'] = $total;

			return response($res);
		}
		else{
			$res['success'] = false;
			$res['message'] = "Invalid menu";
		}
	}

	public function get_list(Request $request, $menu){
		if($menu == 'pending'){
			$reimburse = Reimburse::where('status', 0)->get();
			if($reimburse != null){
				if($reimburse->count() > 0){
					$res['success'] = true;
					$res['result'] = $reimburse;
					$i=0;
					foreach($reimburse as $reimburselist)
					{
						$user = User::find($reimburselist->user()->first()->id);
						$project = Project::find($reimburselist->project()->first()->id);
						$res['result'][$i]['user_name'] = $user->nama;
						$res['result'][$i]['project_name'] = $project->project_name;
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
		}
		else if($menu == 'accepted'){
			$reimburse = Reimburse::where('status', 1)->get();
			if($reimburse != null){
				if($reimburse->count() > 0){
					$res['success'] = true;
					$res['result'] = $reimburse;
					$i=0;
					foreach($reimburse as $reimburselist)
					{
						$user = User::find($reimburselist->user()->first()->id);
						$project = Project::find($reimburselist->project()->first()->id);
						$res['result'][$i]['user_name'] = $user->nama;
						$res['result'][$i]['project_name'] = $project->project_name;
						$i++;
					}

					return response($res);
					}else{
					$res['success'] = false;
					$res['message'] = "No accepted reimbursements";

					return response($res);
				}
			}
		}
		else if($menu == 'rejected'){
			$reimburse = Reimburse::where('status', 2)->get();
			if($reimburse != null){
				if($reimburse->count() > 0){
					$res['success'] = true;
					$res['result'] = $reimburse;
					$i=0;
					foreach($reimburse as $reimburselist)
					{
						$user = User::find($reimburselist->user()->first()->id);
						$project = Project::find($reimburselist->project()->first()->id);
						$res['result'][$i]['user_name'] = $user->nama;
						$res['result'][$i]['project_name'] = $project->project_name;
						$i++;
					}

					return response($res);
					}else{
					$res['success'] = false;
					$res['message'] = "No rejected reimbursements";

					return response($res);
				}
			}
		}
	}

	public function accept(Request $request, $id)
	{
		$reason = "";
		if($request->has('reason'))
			$reason = $request->input('reason');
		$reimburse = Reimburse::find($id);
		if($reimburse){
			if($reimburse->status != 1){
				$reimburse->status = 1;
				$reimburse->checked = 1;
				$reimburse->reason = $reason;
				if($reimburse->save()){
					$res['success'] = true;
					$res['message'] = "Reimburse ID ".$id." has been accepted.";

					return response($res);
				}else{
					$res['succes'] = false;
					$res['message'] = "Error in saving the query";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "Reimburse ID ".$id." is already accepted.";

				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "Could not find reimburse data with id ".$id;

			return response($res);
		}
	}

	public function reject(Request $request, $id)
	{
		$reason = "";
		if($request->has('reason'))
			$reason = $request->input('reason');
		$reimburse = Reimburse::find($id);
		if($reimburse){
			if($reimburse->status != 2){
				$reimburse->status = 2;
				$reimburse->checked = 1;
				$reimburse->reason = $reason;
				if($reimburse->save()){
					$res['success'] = true;
					$res['message'] = "Reimburse ID ".$id." has been rejected.";

					return response($res);
				}else{
					$res['succes'] = false;
					$res['message'] = "Error in saving the query";

					return response($res);
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "Reimburse ID ".$id." is already rejected.";

				return response($res);
			}
		}
		else{
			$res['success'] = false;
			$res['message'] = "Could not find reimburse data with id ".$id;

			return response($res);
		}
	}

	public function get_pending(Request $request, $menu){
		if($menu === 'totalcount'){
			$reimburse = Reimburse::where('status', 0)->get();
			if($reimburse){
				if($reimburse->count() > 0){						
					$res['success'] = true;
					$res['result']['count'] = $reimburse->count();

					return response($res);
				}else{
					$res['success'] = false;
					$res['message'] = "No pending reimburses";

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
			$reimburse = Reimburse::all();
			if($reimburse !== null){
				$totalcost = 0;
				foreach($reimburse as $reimbursedata)
				{
					if($reimbursedata->status == 1)
						$totalcost += $reimbursedata->total_cost;
					else{

					}
				}
				if($totalcost > 0){
					$res['success'] = true;
					$res['result']['amount'] = $totalcost;

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
	
	public function get_reimburse_from_project_by_user_id($pid, $id){
		$user = User::find($id);
		if($user){
			$project = $user->project()->find($pid);
			if($project){
				$res['success'] = true;
				$reimburse = $project->reimburse()->get()->where('user_id', $id);
				$reimburse = $reimburse->values();
				$res['result'] = $reimburse;
				$i=0;
				foreach($reimburse as $reimburse_list){
					$res['result'][$i]['image'] = "";
					$image = app('App\Http\Controllers\ReimburseController')->getImagePath($project->id, $reimburse_list->id);
					if($image != "null"){
						$fileData = file_get_contents($image);
						$res['result'][$i]['image'] = base64_encode($fileData);
					}
					else{
						$res['result'][$i]['image'] = "None";
					}
					$i++;
				}

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
	
	public function create(Request $request)
	{
		$project_id = $request->input('project_id');
		$user_id = $request->input('user_id');
		$date = $request->input('date');
		$category = $request->input('category');
		$cost = $request->input('cost');
		$details = $request->input('details');
		if($request->hasFile('picture'))
			$file = $request->file('picture');
		else
			$file = null;

		$project = Project::where('id', $project_id)->first();
		if($project){
			if($project->user()->find($user_id)==true){
				$reimburse = Reimburse::create([
					'project_id' => $project_id,
					'user_id' => $user_id,
					'date' => $date,
					'category' => $category,
					'cost' => $cost,
					'details' => $details
				]);

				if($reimburse){
					$res['success'] = true;
					$res['message'] = 'Success adding new reimburse';
					app('App\Http\Controllers\ProjectController')->update_cost($project_id);

				}else{
					$res['success'] = false;
					$res['message'] = 'Failed adding new reimburse';

					return response($res);
				}

				$re = Reimburse::where('id', $reimburse->id)->first();
				if($re !=null ){
					if($file != null){
						if($file->isValid()){
							$project_id = $reimburse->project_id;
							$id = $re->id;
							$filename = "reimbursePic".$id.".".$file->getClientOriginalExtension();
							$re->picture = $filename;
							$re->save();
							$destinationPath = "../../cms/images/p$project_id/";
							$file->move($destinationPath,$filename);

							$res['file'] = "Uploaded successfully";

							return response($res);
						}
						else{
							$res['file'] = "Invalid file";
							
							return response($res);
						}
					}
					else{
						$res['file'] = "No file attached";
						return response($res);
					}
				}
			}
			else{
				$res['success'] = false;
				$res['message'] = "User ID $user_id is not registered to Project ID $project_id";

				return response($res);
			}
		}
		else
		{
			$res['success'] = false;
			$res['message'] = 'Invalid Project ID';
			
			return response($res);
		}
	}

	public function getImagePath($pid, $rid){
		$path = "../../cms/images/p$pid/reimbursePic$rid";

		$matching = glob($path . ".*");
		
		if(sizeof($matching) > 0){
			$info = pathinfo($matching[0]);
			$ext = $info['extension'];

			return $path.'.'.$ext;
		}
		else{
			return "null";
		}
	}
	// public function update(Request $request, $menu, $id)
	// {
	// 	if($request->has(''))
	// 	if($request->has('name')){
	// 		$reimburse = Reimburse::find($id);
	// 		$reimburse->name = $request->input('name');
	// 		if($reimburse->save()){
	// 			$res['success'] = true;
	// 			$res['message'] = 'Success update '.$request->input('name');

	// 			return response($res);
	// 		}
	// 	}else{
	// 		$res['success'] = false;
	// 		$res['message'] = 'Please fill name Reimburse';
	// 		return response($res);
	// 	}
	// }

	// public function delete(Request $request, $id){
	// 	$reimburse = Reimburse::find($id);
	// 	if($reimburse->delete($id)){
	// 		$res['success'] = true;
	// 		$res['message'] = "Success deleting Reimburse with id ".$id;

	// 		return response($res);
	// 	}
	// }
}
