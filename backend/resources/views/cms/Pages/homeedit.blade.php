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

<div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Home Page</h3>
      </div>
      <div class="card-body">

        <form method="POST" action="{{ route('edit-home',['id'=>1]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

                <!-- Input field for 'hero_image' -->
                <div class="form-group">
                    <label for="hero_image">Hero Image</label><br>
                    <div id="image-tampil">
                        <img id="imageDB"src="{{asset($dataHome->hero_image)}}" alt="gagal">
                    </div>
                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                </div>

                <!-- Input field for 'about_title' -->
                <div class="form-group">
                    <label for="about_title">About Title</label>
                    <input type="text" name="about_title" class="form-control" required maxlength="255" value="{{ old('about_title', $dataHome->about_title) }}">
                </div>

                <!-- Input field for 'about_desc' -->
                <div class="form-group">
                    <label for="about_desc">About Description</label>
                    <textarea name="about_desc" class="form-control" required>{{ old('about_desc', $dataHome->about_desc) }}</textarea>
                </div>

                <!-- Input field for 'service_title' -->
                <div class="form-group">
                    <label for "service_title">Service Title</label>
                    <input type="text" name="service_title" class="form-control" required maxlength="255" value="{{ old('service_title', $dataHome->service_title) }}">
                </div>

                <!-- Input field for 'service_desc' -->
                <div class="form-group">
                    <label for="service_desc">Service Description</label>
                    <textarea name="service_desc" class="form-control" required>{{ old('service_desc', $dataHome->service_desc) }}</textarea>
                </div>

                <!-- Input field for 'partner_title' -->
                <div class="form-group">
                    <label for="partner_title">Partner Title</label>
                    <input type="text" name="partner_title" class="form-control" required maxlength="255" value="{{ old('partner_title', $dataHome->partner_title) }}">
                </div>

                <!-- Input field for 'partner_desc' -->
                <div class="form-group">
                    <label for="partner_desc">Partner Description</label>
                    <textarea name="partner_desc" class="form-control" required>{{ old('partner_desc', $dataHome->partner_desc) }}</textarea>
                </div>

                <!-- Input field for 'article_title' -->
                <div class="form-group">
                    <label for="article_title">Article Title</label>
                    <input type="text" name="article_title" class="form-control" required maxlength="255" value="{{ old('article_title', $dataHome->article_title) }}">
                </div>

                <!-- Input field for 'article_desc' -->
                <div class="form-group">
                    <label for="article_desc">Article Description</label>
                    <textarea name="article_desc" class="form-control" required>{{ old('article_desc', $dataHome->article_desc) }}</textarea>
                </div>

            <!-- Submit button -->
            <button clas="fixed-bottom" type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>



































@endsection
