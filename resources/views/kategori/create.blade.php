@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
<div class="card-header">
<h3 class="card-title">{{ $page->title }}</h3>
<div class="card-tools"></div>
</div>
<div class="card-body">
<form method="POST" action="{{ url('kategori') }}" class="form-horizontal">
@csrf
<div class="form-group row">
<label class="col-1 control-label col-form-label">Kategori</label>
<div class="col-11">
<select class="form-control" id="kategori_id" name="kategori_id" required>
<option value="">- Pilih kategori -</option>
@foreach($kategori as $item)
<option value="{{ $item->kategori_id }}">{{ $item->kategori_nama}}</option>
@endforeach
</select>
@error('kategori_id')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Kategori kode</label>
<div class="col-11">
<input type="text" class="form-control" id="kategori_kode" name="kategori_kode"value="{{ old('kategori_kode') }}" required>
@error('kategori_kode')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Kategori Nama</label>
<div class="col-11">
<input type="text" class="form-control" id="kategori_nama" name="kategori_nama"value="{{ old('kategori_nama') }}" required>
@error('nama')
<small class="form-text text-danger">{{ $message }}</small>
@enderror
{{-- </div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label">Password</label>
<div class="col-11">
<input type="password" class="form-control" id="password"name="password" required>
@error('password')
<small class="form-text text-danger">{{ $message }}</small>
@enderror --}}
</div>
</div>
<div class="form-group row">
<label class="col-1 control-label col-form-label"></label>
<div class="col-11">
<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
<a class="btn btn-sm btn-default ml-1" href="{{ url('kategori')}}">Kembali</a>
</div>
</div>
 </form>
</div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush