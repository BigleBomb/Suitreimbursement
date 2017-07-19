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
		$reimburse = Reimburse::find($id)->first();

		if($reimburse){
			$user = $reimburse->user()->get();
			$res['success'] = true;
			$res['result'] = $reimburse;
			$res['result']['user_data'] = $user;
			return response($res);
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

	public function get_list(Request $request, $menu){
		if($menu == 'pending'){
			$project = Project::where('status', 0)->get();
			if($project != null){
				if($project->count() > 0){
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
				else{
					$res['success'] = false;
					$res['message'] = "No pending projectments";

					return response($res);
				}
			}
		}
		else if($menu == 'accepted'){
			$project = Project::where('status', 1)->get();
			if($project != null){
				if($project->count() > 0){
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
					}else{
					$res['success'] = false;
					$res['message'] = "No accepted projectments";

					return response($res);
				}
			}
		}
		else if($menu == 'rejected'){
			$project = Project::where('status', 2)->get();
			if($project != null){
				if($project->count() > 0){
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
					}else{
					$res['success'] = false;
					$res['message'] = "No rejected projectments";

					return response($res);
				}
			}
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
	
	public function create(Request $request)
	{
		$reimburse_id = $request->input('reimburse_id');
		$date = $request->input('date');
		$category = $request->input('category');
		$cost = $request->input('cost');
		if($request->hasFile('picture'))
			$file = $request->file('picture');
		else
			$file = null;

		$reimburse = Reimburse::where('id', $reimburse_id)->first();
		if($reimburse){
			$reimburse = Reimburse::create([
				'reimburse_id' => $reimburse_id,
				'date' => $date,
				'category' => $category,
				'cost' => $cost,
			]);

			if($reimburse){
				$res['success'] = true;
				$res['message'] = 'Success adding new reimburse';

			}else{
				$res['success'] = false;
				$res['message'] = 'Failed adding new reimburse';

				return response($res);
			}

			$it = Reimburse::where('id', $reimburse->id)->first();
			if($it !=null ){
				if($file != null){
					if($file->isValid()){
						$user_id = $reimburse->user_id;
						$reimburse_id = $it->reimburse_id;
						$id = $it->id;
						$filename = "reimbursePic".$id.".".$file->getClientOriginalExtension();
						$it->picture = $filename;
						$it->save();
						$destinationPath = "../../cms/images/u$user_id/r$reimburse_id/";
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
		else
		{
			$res['success'] = false;
			$res['message'] = 'Invalid reimburse id';
			
			return response($res);
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
