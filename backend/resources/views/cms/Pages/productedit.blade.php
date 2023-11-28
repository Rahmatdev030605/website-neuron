@extends('layouts.master')

@section('content')
<style>
    #image-tampil {
        width: 500px;
        height: auto;
        border: 1px solid black;
    }

    #imageDB {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-group {
        margin-bottom: 30px
    }
</style>

<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-video">Product Page</h3>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('product.update',['id'=>1]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Input field for 'hero_image' -->
                <div class="form-group">
                    <label for="hero_image">Hero Image</label><br>
                    <div id="image-tampil">
                        <img id="imageDB" src="{{asset($dataProduct->hero_image)}}" alt="gagal">
                    </div>
                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                </div>

                <!-- Input field for 'hero_title' -->
                <div class="form-group">
                    <label for="hero_title">Hero Title</label>
                    <input type="text" name="hero_title" class="form-control" required maxlength="255" value="{{ old('hero_title', $dataProduct->hero_title ?? '') }}">
                </div>

                <!-- Input field for 'hero_desc' -->
                <div class="form-group">
                    <label for="hero_desc">Hero Desc</label>
                    <input type="text" name="hero_desc" class="form-control" required maxlength="255" value="{{ old('hero_desc', $dataProduct->hero_desc ?? '') }}">
                </div>
                <!-- Input field for 'about_title' -->

                <!-- Submit button -->
                <button class="fixed-bottom" type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

@endsection
