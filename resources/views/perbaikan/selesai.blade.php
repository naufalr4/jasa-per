@extends('layout.app')

@section('title', 'Data Perbaikan')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card title">
            Status Selesai
        </h4>
    </div>

     <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>id perbaikan</th>
                    <th>Tanggal Perbaikan</th>
                    <th>Konsumen</th>
                    <th>grand total</th>
                    <th>Aksi</th>
                </tr>
              </thead> 
              <tbody></tbody> 
            </table>
        <div>
    </div>
</div>

@endsection

@push('js')
    <script>
        $(function(){
            
            function rupiah(angka){
                const format = angka.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                return 'Rp ' + convert.join('.').split('').reverse().join('')
            }

            function date(date){
                var date = new Date(date);
                var day = date.getDate(); //Date of the month: 2 in our example
                var month = date.getMonth(); //Month of the Year: 0-based index, so 1 in our example
                var year = date.getFullYear() //Year: 

                return `${day}-${month}-${year}`;
            }

            const token = localStorage.getItem('token')
            $.ajax({
                url : '/api/perbaikan/selesai',
                headers: {
                            "Authorization": 'Bearer'+token
                        },
                success : function ({data}) {

                    let row;
                    data.map(function (val, index) {
                        row += `
                        <tr> 
                            <td>${index+1}</td>
                            <td>${val.id}</td>
                            <td>${date(val.created_at)}</td>
                            <td>${val.konsumen.nama_konsumen}</td>
                            <td>${rupiah(val.grand_total)}</td>

                          
                            
                         </tr>
                        `;
                    });
                    $('tbody').append(row)
                }
            });

            $(document).on('click','.btn-aksi',function(){
                const id = $(this).data('id')

                $.ajax({
                    url : '/api/perbaikan/ubah_status/' + id ,
                    type : 'POST',
                    data : {
                        status : 'Dikonfirmasi'
                    },
                    headers: {
                            "Authorization": 'Bearer'+token
                        },
                        success : function(data){
                            console.log(data)
                        },

                })
            })
        });
    </script>
@endpush