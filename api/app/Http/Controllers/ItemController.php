<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Reimburse;
use App\Item;

class ItemController extends Controller {
	
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function get(Request $request, $id)
	{
		$item = Item::where('reimburse_id', $id)->get();

		if($item->count() > 0){
			$res['success'] = true;
			$res['result'] = $item;
			return response($res);
		}
		else{
			$res['success'] = false;
			$res['message'] = "No item for this Reimburse ID";
			return response($res);
		}
		// $i=0;
		// foreach($item as $itemdata)
		// {
		// 	$reimburse = Reimburse::find($itemdata->reimburse()->first()->id);
		// 	$res['result'][$i]['user_data'] = $user;
		// 	$i++;
		// }
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
			$item = Item::create([
				'reimburse_id' => $reimburse_id,
				'date' => $date,
				'category' => $category,
				'cost' => $cost,
			]);

			if($item){
				$res['success'] = true;
				$res['message'] = 'Success adding new item';

			}else{
				$res['success'] = false;
				$res['message'] = 'Failed adding new item';

				return response($res);
			}

			$it = Item::where('id', $item->id)->first();
			if($it !=null ){
				if($file != null){
					if($file->isValid()){
						$user_id = $reimburse->user_id;
						$reimburse_id = $it->reimburse_id;
						$id = $it->id;
						$filename = "itemPic".$id.".".$file->getClientOriginalExtension();
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
