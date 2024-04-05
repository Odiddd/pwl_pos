@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
<div class="card-header">
<h3 class="card-title">{{ $page->title }}</h3>
<div class="card-tools"></div>
</div>
<div class="card-body">
@empty($stok)
<div class="alert alert-danger alert-dismissible">
<h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
Data yang Anda cari tidak ditemukan.
</div>
<a href="{{ url('stok') }}" class="btn btn-sm btn-default mt2">Kembali</a>
@else
<form method="POST" action="{{ url('/stok/'.$stok->stok_id) }}"class="form-horizontal">
@csrf
{!! method_field('PUT') !!} 
<div class="form-group row">
<label class="col-1 control-label col-form-label">stok</label>
<div class="col-11">
<select class="form-control" id="stok_id" name="stok_id" required>
<option value="">- Pilih stok -</option>
@foreach($stok as $item)
<option value="{{ $item->stok_id }}" @if($item->stok_id == $stok->stok_id) selected @endif>{{ $item->stok_nama }}</option>
@endforeach
</select>
@error('stok_id')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Barang Id</label>
<div class="col-11">
<input type="text" class="form-control" id="barang_id"name="barang_id" value="{{ old('barang_id', $barang->barang_id) }}" required>
@error('barang_id')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">User Id</label>
<div class="col-11">
<input type="text" class="form-control" id="user_id" name="user_id"value="{{ old('user_id', $barang->user_id) }}" required>
@error('user_id')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Stok tanggal</label>
<div class="col-11">
<input type="text" class="form-control" id="stok_tanggal" name="stok_tanggal"value="{{ old('stok_tanggal', $barang->stok_tanggal) }}" required>
@error('stok_tanggal')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Stok jumlah</label>
<div class="col-11">
<input type="text" class="form-control" id="stok_jumlah" name="stok_jumlah"value="{{ old('stok_jumlah', $barang->stok_jumlah) }}" required>
@error('stok_jumlah')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
{{-- </div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Password</label>
<div class="col-11">
<input type="password" class="form-control" id="password"name="password">
@error('password')
<small class="form-text text-danger">{{ $message }}</small>
@else
<small class="form-text text-muted">Abaikan (jangan diisi) jika tidak ingin mengganti password user.</small>
@enderror --}}
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label"></label>
<div class="col-11">
<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
<a class="btn btn-sm btn-default ml-1" href="{{ url('stok')}}">Kembali</a>
</div>
</div>
</form>
@endempty
</div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
