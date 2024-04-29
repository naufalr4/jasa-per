@extends('layout.app')

@section('title', 'Data jasa ')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card title">
            Data jasa perbaikan
        </h4>
    </div>

     <div class="card-body">
        <div class="d-flex justify-content-end md-4">
            <a href="#modal-form" class="btn btn-primary modal-tambah">Tambah</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                    <th>No</th>
                     <th>Nama Kategori</th>
                     <th>Nama Subkategori</th>
                     <th>nama jasa</th>
                     <th>deskripsi</th>
                     <th>alamat</th>
                     <th>no hp</th>
                     <th>Jam Buka</th>
                    <th>estimasi harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
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
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-jasa_perbaikan">
                    
                     <div class="form-group">
                        <label for="">Kategori :</label>
                        <select name="id_kategori" id="id_kategori" class="form control">
                        @foreach ($categories as $category)
                           <option value="{{$category->id}}">{{$category->nama_kategori}}</option> 
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Subkategori :</label>
                        <select name="id_subkategori" id="id_subkategori" class="form control">
                        @foreach ($subcategories as $subcategory)
                           <option value="{{$subcategory->id}}">{{$subcategory->nama_subcategory}}</option> 
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nama jasa</label>
                        <input type="text" class="form-control" name="nama_jasa" 
                        placeholder="nama jasa">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi" placeholder="Deskripsi" class="form-control" cols="30" 
                        rows="10" required></textarea>
                    </div>
                     <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control" name="alamat" 
                        placeholder="Alamat">
                    </div>
                     <div class="form-group">
                        <label for="">No HP</label>
                        <input type="text" class="form-control" name="no_tlp" 
                        placeholder="NO HP(WhatsApp)">
                    </div>
                    <div class="form-group">
                        <label for="">Jam Buka</label>
                        <input type="text" class="form-control" name="Jam_Buka" 
                        placeholder="Jam Buka">
                    </div>
                     <div class="form-group">
                        <label for="">estimasi harga</label>
                        <input type="text" class="form-control" name="estimasi_harga" 
                        placeholder="estimasi harga">
                    </div>
                    <div class="form-group">
                        <label for="">Gambar</label>
                        <input type="file" class="form-control" name="gambar">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')
    <script>
        $(function(){

            $.ajax({
                url : '/api/jasas/',
                success : function ({data}) {

                    let row;
                    data.map(function (val, index) {
                        row += `
                        <tr> 
                            <td>${val.id}</td>
                            <td>${val.category.nama_kategori}</td>
                            <td>${val.subcategory.nama_subcategory}</td>
                            <td>${val.nama_jasa}</td>
                            <td>${val.deskripsi}</td>
                            <td>${val.alamat}</td>
                            <td>${val.no_tlp}</td>
                            <td>${val.Jam_Buka}</td>
                            <td>${val.estimasi_harga}</td>
                            <td><img src="/uploads/${val.gambar}" width="120"></td>
                            <td>
                                <a data-toggle="modal" href="#modal-form" data-id="${val.id}" class="btn btn-warning modal-ubah">Edit</a>
                                <a href="#" data-id="${val.id}" class="btn btn-danger btn-hapus">Hapus</a>
                            </td>
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
                        url : '/api/jasas/' + id,
                        type : 'DELETE',
                        headers: {
                            "Authorization": 'Bearer'+token
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
                $('select[name="id_subcategory"]').val('');
                     $('select[name="id_kategori"]').val('');
                     $('input[name="nama_jasa"]').val('')
                    $('textarea[name="deskripsi"]').val('')
                     $('input[name="alamat"]').val('')
                      $('input[name="no_tlp"]').val('')
                    $('input[name="Jam_Buka"]').val('')
                    $('input[name="estimasi_harga"]').val('');

                $('.form-jasa_perbaikan').submit(function(e){
                    e.preventDefault()
                    const token = localStorage.getItem('token')

                    const frmdata = new FormData(this);

                    $.ajax({
                        url : 'api/jasas',
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
                               
                                location.reload();
                                
                            }
                        }
                     })
                });
            });

            $(document).on('click', '.modal-ubah', function(){
                $('#modal-form').modal('show')
                const id = $(this).data('id');

                $.get('/api/jasas/'+ id, function({data}){
                    $('select[name="id_subcategory"]').val(data.id_subcategory);
                     $('select[name="id_kategori"]').val(data.id_kategori);
                     $('input[name="nama_jasa"]').val(data.nama_jasa);
                    $('textarea[name="deskripsi"]').val(data.deskripsi);
                    $('input[name="alamat"]').val(data.alamat);
                    $('input[name="no_tlp"]').val(data.no_tlp);
                    $('input[name="Jam_Buka"]').val(data.Jam_Buka);
                    $('input[name="estimasi_harga"]').val(data.estimasi_harga);
                });

                $('.form-jasa_perbaikan').submit(function(e){
                    e.preventDefault()
                    const token = localStorage.getItem('token')

                    const frmdata = new FormData(this);

                    $.ajax({
                        url : `api/jasas/${id}?_method=PUT`,
                        type : 'POST',
                        data : frmdata,
                        cache: false,
                        contentType : false,
                        processData : false,
                        headers: {
                            "Authorization":'Bearer'+token
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