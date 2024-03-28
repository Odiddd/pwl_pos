<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDatatable;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class KategoriController extends Controller
{
    public function index(KategoriDatatable $dataTable){
        return$dataTable->render('kategori.index');
    }
    public function create():View
    {
        return view('kategori.create');
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_kode'=> 'bail|required|unique:post|max:255',
            'kategori_nama'=> 'required',
        ]);
        return redirect('/kategori');
    }
    public function edit($id){
        $kategori = KategoriModel::find($id);
        return view('kategori.edit', ['data'=>$kategori]);
    }
    public function update(Request $request, $id){
        $kategori = KategoriModel::find($id);
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;

        $kategori->save();
        return redirect('/kategori');
    }
    public function delete($id){
        $kategori = KategoriModel::find($id);
        $kategori->delete();
        return redirect('/kategori');
    }
}
