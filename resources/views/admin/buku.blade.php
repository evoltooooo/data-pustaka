@extends('layouts.adminapp')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 mt-4">
                    <div class="callout bg-dark callout-info">
                        <h5 class="font-weight-bold"><i class="fas fa-book pr-3"></i>Data Buku</h5>
                    </div>
                </div>

                <div class="col-12">
                     <a href="{{ url('buku/add') }}">
                    <button class="btn btn-lg w-100 bg-primary">
                       <i class="fas fa-plus-circle mr-2"></i>Daftarkan Buku
                    </button>
                    </a> 
                </div>

                <div class="col-sm-12 mt-4">
                    <div class="card text-white bg-dark">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-dark table-bordered table-hover ml-auto">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Jenis</th>
                            <th>Genre</th>
                            <th>No. Panggil</th>
                            <th>Volume</th>
                            <th>ISBN/ISSN</th>
                            <th>Tahun Terbit</th>
                            <th>Sampul</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($buku as $r)   
                        <tr>
                            <td>{{ $loop -> iteration }}</td>
                            <td>{{ $r -> judul }}</td>
                            <td>{{ $r -> penulis }}</td>
                            <td>{{ $r -> jenis }}</td>
                            <td>{{ $r -> genre }}</td>
                            <td>{{ $r -> no_panggil }}</td>
                            <td>{{ $r -> volume }}</td>
                            <td>{{ $r -> issn }}</td>
                            <td>{{ $r -> tahun_terbit }}</td>
                            <td><img src="{{ url('uploads/cover/thumbnail/thumb_' . $r -> cover . '.webp') }}" class="img img-fluid"></td>
                            <td class="d-flex-inline justify-content-center align-items-center">
                                <div class="pr-2">
                                    <form method="POST" action="{{ route('deleteBuku', $r -> idBuku) }}">                                        
                                    <a href="{{ route('editBuku', $r -> idBuku) }}" class="btn bg-warning">
                                        Edit
                                    </a>
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                 </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script> 
    <script>
        $(document).ready( function () {
            $('#example2').DataTable();
        } );
    </script>
    <script>
        $('.btn-delete').click(function (e){
            e.preventDefault();
            let form = $(this).parents('form');  
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                theme: "dark"
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
                });
        });
    </script>
    
@endsection