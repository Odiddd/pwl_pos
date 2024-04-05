<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Illuminate\Database\QueryException;
use App\Models\LevelModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
            $breadcrumb = (object)[
                'title' => 'Daftar stok',
                'list' => ['Home', 'stok']
            ];

            $page = (object)[
                'title' => 'Daftar stok yang terdaftar dalam sistem'
            ];

            $activeMenu = 'stok';
            $stok = StokModel::all();
            return view('stok.index', ['breadcrumb' =>$breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }
    public function tambah()
    {
        return view('stok_tambah');
    }
    public function tambah_simpan(Request $request)
    {
        StokModel::create([
            'barang_id'=>$request->barang_id,
            'user_id'=>$request->user_id,
            'stok_tanggal'=>$request->stok_tanggal,
            'stok_jumlah'=>$request->stok_jumlah
        ]);
        return redirect('/stok');
    }
    public function ubah($id){
        $stok = StokModel::find($id);
        return view('stok_ubah',['data'=>$stok]);
    }
    public function ubah_simpan($id, Request $request){
       $stok = StokModel::find($id);
       $stok->barang_id = $request->barang_id;
       $stok->user_id = $request->user_id;
       $stok->stok_tanggal = $request->stok_tanggal;
       $stok->stok_jumlah = $request->stok_jumlah;

       $stok ->save();
        return redirect('/stok');
    }
    public function hapus($id){
       $stok = StokModel::find($id);
       $stok->delete();
        return redirect('/Stok');
    }
    public function list(Request $request)
{
$stok = StokModel::select('barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah');
//Filter data user berdasarkan level id
if($request->stok_id){
    $stok->where('stok_id', $request->stok_id);
}
return DataTables::of($stok)
->addIndexColumn() // menambahkan kolom index / no urut (default namakolom: DT_RowIndex)
->addColumn('aksi', function ($stok) { // menambahkan kolom aksi
$btn = '<a href="'.url('/stok/' . $stok->stok_id).'" class="btn btninfo btn-sm">Detail</a> ';
$btn .= '<a href="'.url('/stok/' . $stok->stok_id . '/edit').'"class="btn btn-warning btn-sm">Edit</a> ';
$btn .= '<form class="d-inline-block" method="POST" action="'.url('/stok/'.$stok->stok_id).'">'. csrf_field() . method_field('DELETE') .'<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
return $btn;
})
->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
->make(true);
}
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah stok',
            'list' => ['Home', 'stok', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah stok baru'
        ];
        $level = LevelModel::all();
        $activeMenu = 'stok';

        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request){
        $request->validate([
            'barang_id' => 'required|Big integer|unique:m_barang,barang_id',
            'user_id' => 'required|Big integer|unique:m_user,user_id',
            'stok_tanggal' => 'required|datetime',
            'stok_jumlah' => 'required|integer'
        ]);
        StokModel::create([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal,' => $request->stok_tanggal,
            'stok_jumlah,' => $request->stok_jumlah,
        ]);
        return redirect('/stok')->with('succes', 'Data stok berhasil disimpan');
    }
    public function show(string $id){
        $stok = StokModel::with('level')->find($id);
        $breadcrumb = (object)[
            'title' => 'Detail stok', 
            'list' => ['Home', 'stok', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail stok'
        ];
        $activeMenu = 'stok';
        return view('stok.show',['breadcrumb'=>$breadcrumb, 'page' => $page, 'stok'=>$stok,'activeMenu'=>$activeMenu]);
    }
    public function edit(string $id)
{
  $stok = StokModel::find($id);
  $level = LevelModel::all();

  $breadcrumb = (object) [
    'title' => 'Edit stok',
    'list' => ['Home', 'stok', 'Edit'],
  ];

  $page = (object) [
    'title' => 'Edit stok',
  ];

  $activeMenu = 'stok';

  return view('stok.edit', ['breadcrumb' => $breadcrumb,'page' => $page,'stok' => $stok,'level' => $level,'activeMenu' => $activeMenu]);
}
public function update(Request $request, string $id)
{

  $request->validate([
    'barang_id' => 'required|Big integer|unique:m_barang,barang_id',
    'user_id' => 'required|Big integer|unique:m_user,user_id',
    'stok_tanggal' => 'required|datetime',
    'stok_jumlah' => 'required|integer'
  ]);

  StokModel::find($id)->update([

    'barang_id' => $request->barang_id,
    'user_id' => $request->user_id,
    'stok_tanggal' => $request->stok_tanggal,
    'stok_jumlah' => $request->stok_jumlah,
  ]);

  return redirect('/stok')->with('success', 'Data stok berhasil diubah');
}

public function destroy(string $id)
{
  $check = StokModel::find($id);
  if (!$check) {
    return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
  }
  try {
    StokModel::destroy($id);
    return redirect('/stok')->with('success', 'Data stok berhasil dihapus');

  } catch (Illuminate\Database\QueryException $e) {
    return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
  }
}

}
