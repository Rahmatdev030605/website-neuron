@extends('layouts.master')
@section('content')
<style>
    #image-tampil,
    #vision-image {
        width: 500px;
        height: auto;
        border: 1px solid black;
    }

    #imageDB,
    #img-vision {
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
            <h3 class="card-title">About Page</h3>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('edit-about',['id'=>1]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Input field for 'hero_title' -->
                <!-- Input field for 'hero_image' -->
                <div class="form-group">
                    <label for="hero_image">Hero Image</label><br>
                    <div id="image-tampil">
                        <img id="imageDB" src="{{asset($dataAbout->hero_image)}}" alt="gagal">
                    </div>
                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                </div>

                <!-- Input field for 'hero_title' -->
                <div class="form-group">
                    <label for="hero_title">Hero Title</label>
                    <input type="text" name="hero_title" class="form-control" value="{{old('hero_title', $dataAbout->hero_title)}}" required maxlength="255">
                </div>
                <!-- Input field for 'about_title' -->
                <div class="form-group">
                    <label for="about_title">About Title</label>
                    <textarea type="text" name="about_title" class="form-control" required maxlength="255" rows="4">{{ old('about_title', $dataAbout->about_title) }}</textarea>
                </div>
                <!-- Input field for 'about_title' -->
                <div class="form-group">
                    <label for="about_desc">About Description</label>
                    <textarea type="text" name="about_desc" class="form-control" required maxlength="255" rows="4">{{ old('about_desc', $dataAbout->about_title) }}</textarea>
                </div>

                <!-- Input field for 'vision_title' -->
                <div class="form-group">
                    <label for="vision_title">Vision Title</label>
                    <input type="text" name="vision_title" class="form-control" value="{{ old('vision_title', $dataAbout->vision_title) }}" required maxlength="255">
                </div>

                <!-- Input field for 'vision_desc' -->
                <div class="form-group">
                    <label for="vision_desc">Vision Description</label>
                    <textarea type="text" name="vision_desc" class="form-control" required maxlength="255" rows="4">{{ old('vision_desc', $dataAbout->vision_desc) }}</textarea>
                </div>

                <!-- Input field for 'hero_image' -->
                <div class="form-group">
                    <label for="vision_image">Vision Image</label><br>
                    <div id="vision-image">
                        <img id="img-vision" src="{{asset($dataAbout->vision_image)}}" alt="gagal">
                    </div>
                    <input type="file" name="vision_image" class="form-control" accept="image/*">
                </div>

                <!-- Input field for 'mission_title' -->
                <div class="form-group">
                    <label for="mission_title">Mission Title</label>
                    <input type="text" name="mission_title" class="form-control" value="{{ old('mission_title', $dataAbout->mission_title) }}" required maxlength="255">
                </div>

                <!-- Input field for 'value_title' -->
                <div class="form-group">
                    <label for="value_title">Value Title</label>
                    <input type="text" name="value_title" class="form-control" value="{{ old('value_title', $dataAbout->value_title) }}" required maxlength="255">
                </div>
                <!-- Input field for value_subtitle'' -->
                <div class="form-group">
                    <label for="value_subtitle">Value Subtitle</label>
                    <input type="text" name="value_subtitle" class="form-control" value="{{ old('value_subtitle', $dataAbout->value_subtitle) }}" required maxlength="255">
                </div>
                <!-- Input field for 'partnership_title' -->
                <div class="form-group">
                    <label for="partnership_title">Partnership Title</label>
                    <input type="text" name="partnership_title" class="form-control" value="{{ old('partnership_title', $dataAbout->partnership_title) }}" required maxlength="255">
                </div>
                <!-- Input field for 'partner_title' -->
                <div class="form-group">
                    <label for="part_cert_title">Partner Certification Title</label>
                    <input type="text" name="part_cert_title" class="form-control" value="{{ old('part_cert_title', $dataAbout->part_cert_title) }}" required maxlength="255">
                </div>
                <!-- Input field for 'partner_title' -->
                <div class="form-group">
                    <label for="part_cert_desc">Partner Certification Description</label>
                    <input type="text" name="part_cert_desc" class="form-control" value="{{ old('part_cert_desc', $dataAbout->part_cert_desc) }}" required maxlength="255">
                </div>
                <!-- Input field for 'partner_title' -->
                <div class="form-group">
                    <label for="certification_title">Certification_title</label>
                    <input type="text" name="certification_title" class="form-control" value="{{ old('certification_title', $dataAbout->certification_title) }}" required maxlength="255">
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary">Update</button>
            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>



@endsection
`
