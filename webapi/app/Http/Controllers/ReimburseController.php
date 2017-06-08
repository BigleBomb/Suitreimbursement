<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reimburse;
use App\User;

class ReimburseController extends Controller {
	
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request){
		$reimburse = new Reimburse;

		$res['success'] = true;
		$res['result'] = $reimburse->all();
	}
	
	public function create(Request $request)
	{
		
		$user_id = $request->input('user_id');
		$tanggal = $request->input('tanggal');
		$nama_proyek = $request->input('nama_proyek');
		$jenis_pengeluaran = $request->input('jenis_pengeluaran');
		$jumlah_pengeluaran = $request->input('jumlah_pengeluaran');
		$foto = $request->input('foto');
		$keterangan = $request->input('keterangan');

		$user = User::where('id', $user_id)->first();
		if($user){
			$reimburse = Reimburse::create([
				'user_id' => $user_id,
				'tanggal' => $tanggal,
				'nama_proyek' => $nama_proyek,
				'jenis_pengeluaran' => $jenis_pengeluaran,
				'jumlah_pengeluaran' => $jumlah_pengeluaran,
				'foto' => $foto,
				'keterangan' => $keterangan,
				'status' => 0,
				'alasan' => ''
			]);

			if($reimburse){
				$res['success'] = true;
				$res['message'] = 'Success adding new reimbursement';
				return response($res);
			}else{
				$res['success'] = false;
				$res['message'] = 'Failed adding new reimbursement';
				return response($res);
			}
		}
		else
		{
			$res['success'] = false;
			$res['message'] = 'Invalid user id';
			return response($res);
		}
	}

	public function get_reimburse(Request $request, $id){
		$reimburse = Reimburse::where('id', $id)->first();
		if($reimburse !== null){
			$res['success'] = true;
			$res['result'] = $reimburse;

			return response($res);
		}else{
			$res['success'] = false;
			$res['message'] = 'Reimburse with id ' . $id . ' not found';
		}
	}
	
	public function update(Request $request, $id)
	{
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
