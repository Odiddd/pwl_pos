<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Illuminate\Database\QueryException;
use App\Models\LevelModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
            $breadcrumb = (object)[
                'title' => 'Daftar Penjualan',
                'list' => ['Home', 'Penjualan']
            ];

            $page = (object)[
                'title' => 'Daftar Penjualan yang terdaftar dalam sistem'
            ];

            $activeMenu = 'penjualan';
            $penjualan = PenjualanModel::all();
            return view('penjualan.index', ['breadcrumb' =>$breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }
    public function tambah()
    {
        return view('penjualan_tambah');
    }
    public function tambah_simpan(Request $request)
    {
        PenjualanModel::create([
            
            'user_id'=>$request->user_id,
            'pembeli'=>$request->pembeli,
            'penjualan_kode'=>$request->penjualan_kode,
            'penjualan_kode'=>$request->penjualan_kode
        ]);
        return redirect('/penjualan');
    }
    public function ubah($id){
        $penjualan = PenjualanModel::find($id);
        return view('penjualan_ubah',['data'=>$penjualan]);
    }
    public function ubah_simpan($id, Request $request){
       $penjualan = PenjualanModel::find($id);
    //    $barang->kategori_id = $request->kategori_id;
       $penjualan->user_id = $request->user_id;
       $penjualan->pembeli = $request->pembeli;
       $penjualan->penjualan_kode = $request->penjualan_kode;
       $penjualan->penjualan_tanggal = $request->penjualan_tanggal;

       $penjualan ->save();
        return redirect('/penjualan');
    }
    public function hapus($id){
        $penjualan = PenjualanModel::find($id);
        $penjualan->delete();
        return redirect('/penjualan');
    }
    public function list(Request $request)
{
$penjualan = PenjualanModel::select( 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal');
//Filter data user berdasarkan level id
if($request->penjualan_nama){
    $penjualan->where('penjualan_nama', $request->penjualan_nama);
}
return DataTables::of($penjualan)
->addIndexColumn() // menambahkan kolom index / no urut (default namakolom: DT_RowIndex)
->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
$btn = '<a href="'.url('/penjualan/' . $penjualan->penjualan_id).'" class="btn btninfo btn-sm">Detail</a> ';
$btn .= '<a href="'.url('/penjualan/' . $penjualan->penjualan_id . '/edit').'"class="btn btn-warning btn-sm">Edit</a> ';
$btn .= '<form class="d-inline-block" method="POST" action="'.url('/penjualan/'.$penjualan->penjualan_id).'">'. csrf_field() . method_field('DELETE') .'<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
return $btn;
})
->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
->make(true);
}
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah penjualan',
            'list' => ['Home', 'penjualan', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah penjualan baru'
        ];
        $penjualan = PenjualanModel::all();
        $activeMenu = 'penjualan';

        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request){
        $request->validate([
            'user_id' => 'Big integer|min:3|unique:m_user,user_id',
            'pembeli' => 'required|String|max:100',
            'penjualan_kode' => 'required|String',
            'penjualan_tanggal' => 'required|datetime'
        ]);
        PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal
        ]);
        return redirect('/penjualan')->with('succes', 'Data penjualan berhasil disimpan');
    }
    public function show(string $id){
        $penjualan = PenjualanModel::with('level')->find($id);
        $breadcrumb = (object)[
            'title' => 'Detail penjualan', 
            'list' => ['Home', 'penjualan', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail penjualan'
        ];
        $activeMenu = 'penjualan';
        return view('penjualan.show',['breadcrumb'=>$breadcrumb, 'page' => $page, 'penjualan'=>$penjualan,'activeMenu'=>$activeMenu]);
    }
    public function edit(string $id)
{
  $penjualan = PenjualanModel::find($id);
  $level = LevelModel::all();

  $breadcrumb = (object) [
    'title' => 'Edit penjualan',
    'list' => ['Home', 'penjualan', 'Edit'],
  ];

  $page = (object) [
    'title' => 'Edit penjualan',
  ];

  $activeMenu = 'penjualan';

  return view('penjualan.edit', ['breadcrumb' => $breadcrumb,'page' => $page,'penjualan' => $penjualan,'level' => $level,'activeMenu' => $activeMenu]);
}
public function update(Request $request, string $id)
{

  $request->validate([
    'user_id' => 'required|Big integer|min:3|unique:m_user,user_id',
    'pembeli' => 'required|String|max:100',
    'penjualan_kode' => 'required|String',
    'penjualan_tanggal' => 'required|datetime'
  ]);

  PenjualanModel::find($id)->update([

    'user_id' => $request->user_id,
    'pembeli' => $request->pembeli,
    'penjualan_kode' => $request->penjualan_kode,
    'penjualan_tanggal' => $request->penjualan_tanggal,

  ]);

  return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
}

public function destroy(string $id)
{
  $check = PenjualanModel::find($id);
  if (!$check) {
    return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
  }
  try {
    PenjualanModel::destroy($id);
    return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');

  } catch (Illuminate\Database\QueryException $e) {
    return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
  }
}

}
