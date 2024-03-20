@extends('layout.app')

@section('title', 'Data Kategori')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card title">
            Data Kategori
        </h4>
    </div>

     <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>id_perbaikan</th>
                    <th>id_konsumen</th>
                    <th>nama_jasa</th>
                    <th>nama_barang</th>
                    <th>kerusakan</th>
                    <th>jenis_perbaikan</th>
                    <th>deskripsi</th>
                    <th>rating</th>
                    
                </tr>
              </thead> 
              <tbody></tbody> 
            </table>
        <div>
    </div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
    </div>
  </div>
</div>

@endsection

@push('js')
    <script>
        $(function(){

            $.ajax({
                url : '/api/ulasans',
                success : function ({data}) {

                    let row;
                    data.map(function (val, index) {
                        row += `
                        <tr> 
                            <td>${index+1}</td>
                            <td>${val.id_perbaikan}</td>
                            <td>${val.id_konsumen}</td>
                            <td>${val.nama_jasa	}</td>
                            <td>${val.nama_barang}</td>
                            <td>${val.kerusakan}</td>
                            <td>${val.jenis_perbaikan}</td>
                            <td>${val.deskripsi}</td>
                            <td>${val.rating}</td>

                         </tr>
                        `;
                    });
                    $('tbody').append(row)
                }
            })

            $(document).on('click', '.btn-hapus', function(){
                const id = $(this).data('id')
                const token = localStorage.getItem('token')

                confirm_dialog = confirm('Apakah yakin dihapus')

                if (confirm_dialog) {
                    $.ajax({
                        url : '/api/categories/' + id,
                        type : 'DELETE',
                        headers: {
                            "Authorization": token
                        },
                        success : function(data){
                            if (data.message == "success"){
                                location.reload()
                                alert('Data berhasil dihapus')
                                
                            }
                        }
                    });
                }
            })

            $('.modal-tambah').click(function(){
                $('#modal-form').modal('show')
                $('input[name="nama_kategori"]').val('')
                $('textarea[name="deskripsi"]').val('')

                $('.form-kategori').submit(function(e){
                    e.preventDefault()
                    const token = localStorage.getItem('token')

                    const frmdata = new FormData(this);

                    $.ajax({
                        url : 'api/categories',
                        type : 'POST',
                        data : frmdata,
                        cache: false,
                        contentType : false,
                        processData : false,
                        headers: {
                            "Authorization":'Bearer'+ token
                        },
                        success : function(data){
                            if (data.success){
                                alert('Data berhasil ditambah')
                                location.reload();
                                
                            }
                        }
                     })
                });
            });

            $(document).on('click', '.modal-ubah', function(){
                $('#modal-form').modal('show')
                const id = $(this).data('id');

                $.get('/api/categories/'+ id, function({data}){
                    $('input[name="nama_kategori"]').val(data.nama_kategori);
                    $('textarea[name="deskripsi"]').val(data.deskripsi);
                });

                $('.form-kategori').submit(function(e){
                    e.preventDefault()
                    const token = localStorage.getItem('token')

                    const frmdata = new FormData(this);

                    $.ajax({
                        url : 'api/categories/${id}?_method=PUT',
                        type : 'POST',
                        data : frmdata,
                        cache: false,
                        contentType : false,
                        processData : false,
                        headers: {
                            "Authorization":token
                        },
                        success : function(data){
                            if (data.success){
                                alert('Data berhasil diedit')
                                location.reload();
                                
                            }
                        }
                     })
                });
            });

        });
    </script>
@endpush