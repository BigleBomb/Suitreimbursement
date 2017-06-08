<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reimburse extends Model {
	
	protected $table = 'reimburse';

    protected $fillable = [
		'user_id', 'tanggal', 'nama_proyek', 'jenis_pengeluaran', 'jumlah_pengeluaran', 'foto', 'keterangan', 'status', 'alasan'
	];
}
