@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
<div class="card-header">
<h3 class="card-title">{{ $page->title }}</h3>
<div class="card-tools"></div>
</div>
<div class="card-body">
@empty($penjualan)
<div class="alert alert-danger alert-dismissible">
<h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
Data yang Anda cari tidak ditemukan.
</div>
<a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt2">Kembali</a>
@else
<form method="POST" action="{{ url('/penjualan/'.$penjualan->penjualan) }}"class="form-horizontal">
@csrf
{!! method_field('PUT') !!} 
{{-- <div class="form-group row">
<label class="col-1 control-label col-form-label">penjualan</label>
<div class="col-11">
<select class="form-control" id="penjualan" name="penjualan" required>
<option value="">- Pilih penjualan -</option>
@foreach($penjualan as $item)
<option value="{{ $item->penjualan }}" @if($item->penjualan_id == $penjualan->penjualan_id) selected @endif>{{ $item->penjualan_nama }}</option>
@endforeach
</select>
@error('penjualan_id')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div> --}}
<div class="form-group row">
<label class="col-1 control-label col-form-label">User Id</label>
<div class="col-11">
<input type="text" class="form-control" id="user_id"name="user_id" value="{{ old('user_id', $penjualan->user_id) }}" required>
@error('user_id')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Pembeli</label>
<div class="col-11">
<input type="text" class="form-control" id="pembeli" name="pembeli"value="{{ old('pembeli', $penjualan->pembeli) }}" required>
@error('pembeli')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Penjualan Kode</label>
<div class="col-11">
<input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode"value="{{ old('penjualan_kode', $penjualan->penjualan_kode) }}" required>
@error('penjualan_kode')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Penjualan tanggal</label>
<div class="col-11">
<input type="text" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal"value="{{ old('penjualan_tanggal', $penjualan->penjualan_tanggal) }}" required>
@error('penjualan_tanggal')
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
<a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan')}}">Kembali</a>
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
