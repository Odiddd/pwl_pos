<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Illuminate\Database\QueryException;
use App\Models\LevelModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
            $breadcrumb = (object)[
                'title' => 'Daftar Barang',
                'list' => ['Home', 'Barang']
            ];

            $page = (object)[
                'title' => 'Daftar barang yang terdaftar dalam sistem'
            ];

            $activeMenu = 'barang';
            $barang = BarangModel::all();
            return view('barang.index', ['breadcrumb' =>$breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
    public function tambah()
    {
        return view('barang_tambah');
    }
    public function tambah_simpan(Request $request)
    {
        BarangModel::create([
            // 'kategori_id'=>$request->kategori_id,
            'barang_kode'=>$request->barang_kode,
            'barang_nama'=>$request->barang_nama,
            'harga_beli'=>$request->harga_beli,
            'harga_jual'=>$request->harga_jual
        ]);
        return redirect('/barang');
    }
    public function ubah($id){
        $barang = BarangModel::find($id);
        return view('barang_ubah',['data'=>$barang]);
    }
    public function ubah_simpan($id, Request $request){
       $barang = BarangModel::find($id);
    //    $barang->kategori_id = $request->kategori_id;
       $barang->barang_kode = $request->barang_kode;
       $barang->barang_nama = $request->barang_nama;
       $barang->harga_beli = $request->harga_beli;
       $barang->harga_jual = $request->harga_jual;

       $barang ->save();
        return redirect('/barang');
    }
    public function hapus($id){
        $barang = BarangModel::find($id);
        $barang->delete();
        return redirect('/barang');
    }
    public function list(Request $request)
{
$barang = BarangModel::select( 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual');
//Filter data user berdasarkan level id
if($request->barang_nama){
    $barang->where('barang_nama', $request->barang_nama);
}
return DataTables::of($barang)
->addIndexColumn() // menambahkan kolom index / no urut (default namakolom: DT_RowIndex)
->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
$btn = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btninfo btn-sm">Detail</a> ';
$btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'"class="btn btn-warning btn-sm">Edit</a> ';
$btn .= '<form class="d-inline-block" method="POST" action="'.url('/barang/'.$barang->barang_id).'">'. csrf_field() . method_field('DELETE') .'<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
return $btn;
})
->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
->make(true);
}
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah barang',
            'list' => ['Home', 'barang', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah barang baru'
        ];
        $barang = BarangModel::all();
        $activeMenu = 'barang';

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request){
        $request->validate([
            'barang_kode' => 'required|String|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|String|max:100',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);
        BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual
        ]);
        return redirect('/barang')->with('succes', 'Data barang berhasil disimpan');
    }
    public function show(string $id){
        $barang = BarangModel::with('level')->find($id);
        $breadcrumb = (object)[
            'title' => 'Detail Barang', 
            'list' => ['Home', 'Barang', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail barang'
        ];
        $activeMenu = 'barang';
        return view('barang.show',['breadcrumb'=>$breadcrumb, 'page' => $page, 'barang'=>$barang,'activeMenu'=>$activeMenu]);
    }
    public function edit(string $id)
{
  $barang = BarangModel::find($id);
  $level = LevelModel::all();

  $breadcrumb = (object) [
    'title' => 'Edit barang',
    'list' => ['Home', 'barang', 'Edit'],
  ];

  $page = (object) [
    'title' => 'Edit barang',
  ];

  $activeMenu = 'barang';

  return view('barang.edit', ['breadcrumb' => $breadcrumb,'page' => $page,'barang' => $barang,'level' => $level,'activeMenu' => $activeMenu]);
}
public function update(Request $request, string $id)
{

  $request->validate([
    'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
    'barang_nama' => 'required|string|max:100',
    'harga_beli' => 'required|integer',
    'harga_jual' => 'required|integer'
  ]);

  BarangModel::find($id)->update([

    'barang_kode' => $request->barang_kode,
    'barang_nama' => $request->barang_nama,
    'harga_beli' => $request->harga_beli,
    'harga_jual' => $request->harga_jual,

  ]);

  return redirect('/barang')->with('success', 'Data barang berhasil diubah');
}

public function destroy(string $id)
{
  $check = BarangModel::find($id);
  if (!$check) {
    return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
  }
  try {
    BarangModel::destroy($id);
    return redirect('/barang')->with('success', 'Data barang berhasil dihapus');

  } catch (Illuminate\Database\QueryException $e) {
    return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
  }
}

}
