@extends('layouts.master')

@section('content')
<style>
    #image-tampil{
        width: 500px;
        height: auto;
        border: 1px solid black;
    }
    #imageDB{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .form-group{
        margin-bottom: 30px
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Service</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('portofolio') }}">Service</a></li>
                    <li class="breadcrumb-item active">Add Service</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div id="success-message" class="mt-3">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('service-store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="hero_image">Service Image</label><br>
                            <div id="image-tampil">
                                <img id="imageDB"src="" alt="gagal">
                            </div>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control" id="desc" name="desc" required></textarea>
                        </div>

                        <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-primary float-right">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var serviceContainer = $('#service-container');

        $('#button-service').click(function () {
            var newInput = $('<input type="text" class="form-control" name="serviceKeys[]" placeholder="Key Feature">');
            serviceContainer.append(newInput);
        });
    });
</script>
@endsection
