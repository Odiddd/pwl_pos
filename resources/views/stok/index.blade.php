@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
<div class="card-header">
<h3 class="card-title">{{ $page->title }}</h3>
<div class="card-tools">
<a class="btn btn-sm btn-primary mt-1" href="{{ url('stok/create')}}">Tambah</a>
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
          <select class="form-control" id="stok_id" name="stok_id" required>
            <option value="">- Semua -</option>
            @foreach($stok as $item)
              <option value="{{ $item->stok_id }}">{{ $item->stok_nama }}</option>
            @endforeach
          </select>
          <small class="form-text text-muted">stok Pengguna</small>
        </div>
      </div>
    </div>
   </div>
<table class="table table-bordered table-striped table-hover table-sm"id="table_stok">
<thead>
<tr><th>ID</th><th>Barang Id</th><th>User Id</th><th>Stok tanggal</th><th>Stok jumlah</th><th>Aksi</th></tr>
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
    var dataStok = $('#table_stok').DataTable({
      serverSide: true, // serverSide: true, jika ingin menggunakan serverside processing
        ajax: {
        "url": "{{ url('stok/list') }}",
        "dataType": "json",
        "type": "POST",
        "data": function (d) {
          d.stok_id = $('#stok_id').val();
        }
},
columns: [
{
data: "DT_RowIndex", // nomor urut dari laravel datatableaddIndexColumn()
className: "text-center",
orderable: false,
searchable: false
},{
data: "barang_id",
className: "",
orderable: true, // orderable: true, jika ingin kolom ini bisadiurutkan
searchable: true // searchable: true, jika ingin kolom ini bisadicari
},{
data: "user_id",
className: "",
orderable: true, // orderable: true, jika ingin kolom ini bisadiurutkan
searchable: true // searchable: true, jika ingin kolom ini bisadicari
},{
data: "stok_tanggal",
className: "",
orderable: true, // orderable: true, jika ingin kolom ini bisadiurutkan
searchable: true // searchable: true, jika ingin kolom ini bisadicari
},{
data: "stok_jumlah",
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
$('#stok_id').on('change', function(){
  dataStok.ajax.reload();
})
});
</script>
@endpush 