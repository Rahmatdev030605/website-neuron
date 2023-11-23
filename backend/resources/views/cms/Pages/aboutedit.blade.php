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
            <h3 class="card-title">About Page</h3>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('edit-about',['id'=>1]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Input field for 'hero_title' -->
                <div class="form-group">
                    <label for="hero_title">Hero Title</label>
                    <input type="text" name="hero_title" class="form-control" value="{{old('hero_title', $dataAbout->hero_title)}}" required maxlength="255">
                </div>

                <!-- Input field for 'hero_desc' -->
                <div class="form-group">
                    <label for="hero_desc">Hero Description</label>
                    <textarea type="text" name="hero_desc" class="form-control" required maxlength="255" rows="4">{{ old('hero_desc', $dataAbout->hero_desc) }}</textarea>
                </div>

                <!-- Input field for 'hero_image' -->
                <div class="form-group">
                    <label for="hero_image">Hero Image</label><br>
                    <div id="image-tampil">
                        <img id="imageDB" src="{{asset($dataAbout->hero_image)}}" alt="gagal">
                    </div>
                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                </div>

                <!-- Input field for 'activity_image' -->
                <div class="form-group">
                    <label for="activity_image">Activity Image</label>
                    <div id="image-tampil">
                        <img id="imageDB" src="{{asset($dataAbout->activity_image)}}" alt="">
                    </div>
                    <input type="file" name="activity_image" class="form-control" accept="image/*">
                </div>

                <!-- Input field for 'vision_title' -->
                <div class="form-group">
                    <label for="vision_title">Vision Title</label>
                    <input type="text" name="vision_title" class="form-control" value="{{ old('vision_title', $dataAbout->vision_title) }}" required maxlength="255">
                </div>

                <!-- Input field for 'vision_subtitle' -->
                <div class="form-group">
                    <label for "vision_subtitle">Vision Subtitle</label>
                    <input type="text" name="vision_subtitle" class="form-control" value="{{ old('vision_subtitle', $dataAbout->vision_subtitle) }}" required maxlength="255">
                </div>

                <!-- Input field for 'vision_desc' -->
                <div class="form-group">
                    <label for="vision_desc">Vision Description</label>
                    <textarea type="text" name="vision_desc" class="form-control" required maxlength="255" rows="4">{{ old('vision_desc', $dataAbout->vision_desc) }}</textarea>
                </div>

                <!-- Input field for 'vision_image' -->
                <div class="form-group">
                    <label for="vision_image">Vision Image</label>
                    <div id="image-tampil">
                        <img id="imageDB" src="{{asset($dataAbout->vision_image)}}" alt="">
                    </div>
                    <input type="file" name="vision_image" class="form-control" accept="image/*">
                </div>


                <!-- Input field for 'mission_title' -->
                <div class="form-group">
                    <label for="mission_title">Mission Title</label>
                    <input type="text" name="mission_title" class="form-control" value="{{ old('mission_title', $dataAbout->mission_title) }}" required maxlength="255">
                </div>

                <!-- Input field for 'mission_subtitle' -->
                <div class="form-group">
                    <label for="mission_subtitle">Mission Subtitle</label>
                    <input type="text" name="mission_subtitle" class="form-control" value="{{ old('mission_subtitle', $dataAbout->mission_subtitle) }}" required maxlength="255">
                </div>

                <!-- Input field for 'mission_desc' -->
                <div class="form-group">
                    <label for="mission_desc">Mission Description</label>
                    <textarea type="text" name="mission_desc" class="form-control" value="" required maxlength="255" rows="4">{{ old('mission_desc', $dataAbout->mission_desc) }}</textarea>
                </div>

                <!-- Input field for 'mission_image' -->
                <div class="form-group">
                    <label for="mission_image">Mission Image</label>
                    <div id="image-tampil">
                        <img id="imageDB" src="{{asset($dataAbout->mission_image)}}" alt="">
                    </div>
                    <input type="file" name="mission_image" class="form-control">
                </div>

                <!-- Input field for 'value_title' -->
                <div class="form-group">
                    <label for="value_title">Value Title</label>
                    <input type="text" name="value_title" class="form-control" value="{{ old('value_title', $dataAbout->value_title) }}" required maxlength="255">
                </div>

                <!-- Input field for 'value_subtitle' -->
                <div class "form-group">
                    <label for="value_subtitle">Value Subtitle</label>
                    <input type="text" name="value_subtitle" class="form-control" value="{{ old('value_subtitle', $dataAbout->value_subtitle) }}" required maxlength="255">
                </div>

                <!-- Input field for 'value_image' -->
                <!-- <div class="form-group">
                    <label for="mission_image">Value Image</label>
                    <div id="image-tampil">
                        <img id="imageDB" src="{{asset($dataAbout->image)}}" alt="">
                    </div>
                    <input type="file" name="image" class="form-control">
                </div> -->

                <!-- Input field for 'director_title' -->
                <div class="form-group">
                    <label for="director_title">Director Title</label>
                    <input type="text" name="director_title" class="form-control" value="{{ old('director_title', $dataAbout->director_title) }}" required maxlength="255">
                </div>

                <!-- Input field for 'director_subtitle' -->
                <div class="form-group">
                    <label for="director_subtitle">Director Subtitle</label>
                    <input type="text" name="director_subtitle" class="form-control" value="{{ old('director_subtitle', $dataAbout->director_subtitle) }}" required maxlength="255">
                </div>

                <!-- Input field for 'strategic_title' -->
                <div class="form-group">
                    <label for="strategic_title">Strategic Title</label>
                    <input type="text" name="strategic_title" class="form-control" value="{{ old('strategic_title', $dataAbout->strategic_title) }}" required maxlength="255">
                </div>

                <!-- Input field for 'strategic_subtitle' -->
                <div class="form-group">
                    <label for="strategic_subtitle">Strategic Subtitle</label>
                    <input type="text" name="strategic_subtitle" class="form-control" value="{{ old('strategic_subtitle', $dataAbout->strategic_subtitle) }}" required maxlength="255">
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
