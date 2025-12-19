@extends('layouts.adminapp')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 mt-4">
                    <div class="info-box bg-dark">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Buku Terdaftar</span>
                        <span class="info-box-number">
                        {{$buku_count}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                
                <div class="col-12 col-sm-6 col-md-4 mt-4">
                    <div class="info-box bg-dark">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-arrow-alt-circle-up"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Buku Dipinjam</span>
                        <span class="info-box-number">
                        {{$total_buku_dipinjam}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-4 mt-4">
                    <div class="info-box bg-dark">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-circle"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Akun Terdaftar</span>
                        <span class="info-box-number">
                            {{$user_count}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
        </div>
        
    </section>
@endsection