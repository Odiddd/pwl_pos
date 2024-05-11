<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function __invoke(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'pembeli' => 'required',
            'penjualan_kode' => 'required',
            'penjualan_tanggal' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'image' => $request->image,
        ]);
        if($user){
            return response()->json([
                'succes' => true,
                'user' => $user,
            ], 201);
        }
        return response()->json([
            'succes' => false,
        ], 409);
    }
    public function index(){
        return PenjualanModel::all();
    }

    public function store(Request $request){
        $barang = PenjualanModel::create($request->all());
        return response()->json($barang, 201);
    }

    public function show($barang){
        return PenjualanModel::find($barang);
    }

    public function update(Request $request, PenjualanModel $barang){
        $barang->update($request->all());
        return PenjualanModel::find($barang);
    }

    public function destroy(PenjualanModel $barang){
        $barang->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Data terhapus',
        ]);
    }
}
