<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Illuminate\Database\QueryException;
use App\Models\LevelModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class kategoriController extends Controller
{
    public function index()
    {
            $breadcrumb = (object)[
                'title' => 'Kategori Barang',
                'list' => ['Home', 'Kategori']
            ];

            $page = (object)[
                'title' => 'Daftar kategori yang terdaftar dalam sistem'
            ];

            $activeMenu = 'kategori';
            $kategori = KategoriModel::all();
            return view('kategori.index', ['breadcrumb' =>$breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    public function tambah()
    {
        return view('kategori_tambah');
    }
    public function tambah_simpan(Request $request)
    {
        KategoriModel::create([
            'kategori_kode'=>$request->kategori_kode,
            'kategori_nama'=>$request->kategori_nama
        ]);
        return redirect('/kategori');
    }
    public function ubah($id){
        $kategori = KategoriModel::find($id);
        return view('kategori_ubah',['data'=>$kategori]);
    }
    public function ubah_simpan($id, Request $request){
        $kategori = KategoriModel::find($id);
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;

        $kategori ->save();
        return redirect('/kategori');
    }
    public function hapus($id){
        $kategori = KategoriModel::find($id);
        $kategori->delete();
        return redirect('/kategori');
    }
    public function list(Request $request)
{
$kategori = KategoriModel::select('kategori_nama', 'kategori_kode');
//Filter data user berdasarkan level id
if($request->kategori_nama){
    $kategori->where('kategori_nama', $request->kategori_nama);
}
return DataTables::of($kategori)
->addIndexColumn() // menambahkan kolom index / no urut (default namakolom: DT_RowIndex)
->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
$btn = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btninfo btn-sm">Detail</a> ';
$btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'"class="btn btn-warning btn-sm">Edit</a> ';
$btn .= '<form class="d-inline-block" method="POST" action="'.url('/kategori/'.$kategori->kategori_id).'">'. csrf_field() . method_field('DELETE') .'<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
return $btn;
})
->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
->make(true);
}
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah kategori baru'
        ];
        $level = LevelModel::all();
        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request){
        $request->validate([
            'kategori_kode' => 'required|String|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|String|max:100'
        ]);
       KategoriModel::create([
            'kategorin_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);
        return redirect('/kategori')->with('succes', 'Data kategori berhasil disimpan');
    }
    public function show(string $id){
        $kategori = KategoriModel::with('level')->find($id);
        $breadcrumb = (object)[
            'title' => 'Detail kategori', 
            'list' => ['Home', 'kategori', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail kategori'
        ];
        $activeMenu = 'kategori';
        return view('kategori.show',['breadcrumb'=>$breadcrumb, 'page' => $page, 'kategori'=>$kategori,'activeMenu'=>$activeMenu]);
    }
    public function edit(string $id)
{
  $kategori = KategoriModel::find($id);
  $level = LevelModel::all();

  $breadcrumb = (object) [
    'title' => 'Edit Kategori',
    'list' => ['Home', 'Kategori', 'Edit'],
  ];

  $page = (object) [
    'title' => 'Edit Kategori',
  ];

  $activeMenu = 'kategori';

  return view('kategori.edit', ['breadcrumb' => $breadcrumb,'page' => $page,'kategori' => $kategori,'level' => $level,'activeMenu' => $activeMenu]);
}
public function update(Request $request, string $id)
{

  $request->validate([
    'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
    'kategori_nama' => 'required|string|max:100',
  ]);

  KategoriModel::find($id)->update([

    'kategori_kode' => $request->kategori_kode,
    'kategori_nama' => $request->kategori_nama,
  ]);

  return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
}

public function destroy(string $id)
{
  $check = KategoriModel::find($id);
  if (!$check) {
    return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
  }
  try {
    KategoriModel::destroy($id);
    return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');

  } catch (Illuminate\Database\QueryException $e) {
    return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
  }
}

}
