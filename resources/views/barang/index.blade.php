@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
<div class="card-header">
<h3 class="card-title">{{ $page->title }}</h3>
<div class="card-tools">
<a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create')}}">Tambah</a>
</div>
</div>
<div class="card-body">
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
   <div class="row">
    <div class="col-md-12">
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Filter:</label>
        <div class="col-3">
          <select class="form-control" id="barang_id" name="barang_id" required>
            <option value="">- Semua -</option>
            @foreach($barang as $item)
              <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
            @endforeach
          </select>
          <small class="form-text text-muted">Barang Pengguna</small>
        </div>
      </div>
    </div>
   </div>
<table class="table table-bordered table-striped table-hover table-sm"id="table_barang">
<thead>
<tr><th>ID</th><th>Barang Kode</th><th>Barang Nama</th><th>Harga Beli</th><th>Harga Jual</th><th>Aksi</th></tr>
</thead>
</table>
</div>
</div>
@endsection
@push('css')
@endpush
@push('js')
  <script>
    $(document).ready(function() {
    var dataBarang = $('#table_barang').DataTable({
      serverSide: true, // serverSide: true, jika ingin menggunakan serverside processing
        ajax: {
        "url": "{{ url('barang/list') }}",
        "dataType": "json",
        "type": "POST",
        "data": function (d) {
          d.barang_id = $('#barang_id').val();
        }
},
columns: [
{
data: "DT_RowIndex", // nomor urut dari laravel datatableaddIndexColumn()
className: "text-center",
orderable: false,
searchable: false
},{
data: "barang_kode",
className: "",
orderable: true, // orderable: true, jika ingin kolom ini bisadiurutkan
searchable: true // searchable: true, jika ingin kolom ini bisadicari
},{
data: "barang_nama",
className: "",
orderable: true, // orderable: true, jika ingin kolom ini bisadiurutkan
searchable: true // searchable: true, jika ingin kolom ini bisadicari
},{
data: "harga_beli",
className: "",
orderable: true, // orderable: true, jika ingin kolom ini bisadiurutkan
searchable: true // searchable: true, jika ingin kolom ini bisadicari
},{
data: "harga_jual",
className: "",
orderable: true, // orderable: true, jika ingin kolom ini bisadiurutkan
searchable: true // searchable: true, jika ingin kolom ini bisadicari
},{
data: "aksi",
className: "",
orderable: false, // orderable: true, jika ingin kolom ini bisadiurutkan
searchable: false // searchable: true, jika ingin kolom ini bisadicari
}
]
});
$('#barang_id').on('change', function(){
  dataBarang.ajax.reload();
})
});
</script>
@endpush 