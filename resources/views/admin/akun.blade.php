@extends('layouts.adminapp')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 mt-4">
                <div class="callout bg-dark callout-danger">
                    <h5 class="font-weight-bold"><i class="fas fa-book pr-3"></i>Data Akun Admin</h5>
                </div>
            </div>

            <div class="col-sm-12">
                    <div class="card text-white bg-dark">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-dark table-bordered table-hover ml-auto">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($admin as $a)   
                        <tr>
                            <td>{{ $loop -> iteration }}</td>
                            <td>{{ $a -> name }}</td>
                            <td>{{ $a -> email }}</td>
                            <td class="d-flex-inline justify-content-center align-items-center">
                                <div class="pr-2">                                      
                                    <a href="" class="btn bg-warning">
                                        Edit
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-delete">Delete</button>
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


            <div class="col-sm-12 mt-4">
                <div class="callout bg-dark callout-warning">
                    <h5 class="font-weight-bold"><i class="fas fa-book pr-3"></i>Data Akun User</h5>
                </div>
            </div>

            <div class="col-sm-12">
                    <div class="card text-white bg-dark">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-dark table-bordered table-hover ml-auto">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Anggota</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user as $u)   
                        <tr>
                            <td>{{ $loop -> iteration }}</td>
                            <td>{{ $u -> no_user }}</td>
                            <td>{{ $u -> name }}</td>
                            <td>{{ $u -> email }}</td>
                            <td class="d-flex-inline justify-content-center align-items-center">
                                <div class="pr-2">                                      
                                    <a href="" class="btn bg-warning">
                                        Edit
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-delete">Delete</button>
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
    </div>
</section>
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script>
        $(document).ready( function () {
            $('#example2').DataTable();
        } );
</script>
@endsection