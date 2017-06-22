<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Reimburse;
use App\User;

class ReimburseController extends Controller {
	
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
		$reimburse = Reimburse::all();

		$res['success'] = true;
		$res['result'] = $reimburse;
		$i=0;
		foreach($reimburse as $userdata)
		{
			$user = User::find($userdata->user()->first()->id);
			$res['result'][$i]['user_data'] = $user;
			$i++;
		}
		return response($res);
	}

	public function get_last(Request $request, $amount)
	{
		$reimburse = Reimburse::orderBy('id', 'desc')->take($amount)->get();

		$res['success'] = true;
		$res['result'] = $reimburse;
		$i=0;
		foreach($reimburse as $userdata)
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
			$reimburse = Reimburse::create([
				'user_id' => $user_id,
				'date' => $date,
				'project_name' => $project_name,
				'total_cost' => $total_cost,
				'details' => $details,
				'status' => 0,
				'reason' => ''
			]);

			if($reimburse){
				$res['success'] = true;
				$res['message'] = 'Success adding new reimbursement';

			}else{
				$res['success'] = false;
				$res['message'] = 'Failed adding new reimbursement';

				return response($res);
			}

			$re = Reimburse::where('id', $reimburse->id)->first();
			if($re !=null ){
				if($file->isValid()){
					$id = $re->id;
					$filename = "reimbursePic".$id.".".$file->getClientOriginalExtension();
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
		$reimburse = Reimburse::orderBy('created_at', 'desc')->first();
		if($reimburse != null){
			$res['success'] = true;
			$res['result'] = $reimburse;

			return response($res);
		}
		else{
			$res['success'] = false;
			$res['message'] = "Failed to get reimburse data";

			return response($res);
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
					foreach($reimburse as $userdata)
					{
						$user = User::find($userdata->user()->first()->id);
						$res['result'][$i]['user_data'] = $user;
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
					foreach($reimburse as $userdata)
					{
						$user = User::find($userdata->user()->first()->id);
						$res['result'][$i]['user_data'] = $user;
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
					foreach($reimburse as $userdata)
					{
						$user = User::find($userdata->user()->first()->id);
						$res['result'][$i]['user_data'] = $user;
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

	public function get_pending(Request $request, $menu){
		if($menu === 'totalcount'){
			$reimburse = Reimburse::where('status', 0)->count();
			if($reimburse != null){
				if($reimburse > 0){						
					$res['success'] = true;
					$res['result']['count'] = $reimburse;

					return response($res);
				}else{
					$res['success'] = false;
					$res['message'] = "There is no pending Reimbursements";

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
				$pend = 0;
				foreach($reimburse as $reimdata)
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

	public function get_reimburse(Request $request, $id){
		$reimburse = Reimburse::where('id', $id)->first();
		if($reimburse !== null){
			$reimburse = Reimburse::find($id);
			$user = $reimburse->user()->get();
			$res['success'] = true;
			$res['result'] = $reimburse;
			$res['result']['user_data'] = $user;

			return response($res);
		}else{
			$res['success'] = false;
			$res['message'] = 'Reimburse with id ' . $id . ' not found';

			return response($res);
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
				$reimburse->alasan = $reason;
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
				$reimburse->alasan = $reason;
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
	
	public function update(Request $request, $menu, $id)
	{
		if($request->has(''))
		if($request->has('name')){
			$reimburse = Reimburse::find($id);
			$reimburse->name = $request->input('name');
			if($reimburse->save()){
				$res['success'] = true;
				$res['message'] = 'Success update '.$request->input('name');

				return response($res);
			}
		}else{
			$res['success'] = false;
			$res['message'] = 'Please fill name Reimburse';
			return response($res);
		}
	}

	public function delete(Request $request, $id){
		$reimburse = Reimburse::find($id);
		if($reimburse->delete($id)){
			$res['success'] = true;
			$res['message'] = "Success deleting Reimburse with id ".$id;

			return response($res);
		}
	}
}
