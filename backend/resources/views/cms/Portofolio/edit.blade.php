@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Portofolio</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('portofolio') }}">Portofolio</a></li>
                    <li class="breadcrumb-item active">Edit Portofolio</li>
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
                    <form action="{{ route('portofolio-update', $portofolio->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="service">Service</label>
                            <select type="text" class="form-control" id="service_id" name="service_id" required>
                                @foreach($services as $service)
                                <option value="{{$service->id}}" {{$portofolio->service_id == $service->id ? 'selected' : ''}}>{{$service->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $portofolio->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $portofolio->customer_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control" id="desc" name="desc" required>{{ $portofolio->desc }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="details">Detail</label>
                            <input type="text" class="form-control" id="details" name="details" value="{{ $portofolio->details }}" required></input>
                        </div>

                        <div class="form-group">
                            <label for="our_solution">Solution</label>
                            <textarea class="ckeditor form-control" id="our_solution" name="our_solution">{{ $portofolio->our_solution }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="created_at">Date</label>
                            <input type="datetime-local" class="form-control" id="created_at" name="created_at" value="{{ $portofolio->created_at }}" required>
                        </div>

                        <div class="form-group">
                            <label for="successProject">Success Project</label>
                            <select class="form-control" id="successProject" name="successProject">
                                @foreach ($successProjectOption as $value => $label)
                                <option value="{{ $value }}" {{ $portofolio->successProject == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image" class="label-upload">Choose an image:</label>
                            <label for="image" class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <span class="custom-file-label">No file chosen</span>
                            </label>
                            <img src="{{ asset($portofolio->image) }}" alt="{{ $portofolio->name }}" class="mt-2" style="max-width: 200px;">
                        </div>

                        <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    ClassicEditor
        .create( document.querySelector( '#our_solution' ) )
        .then( editor => {
            console.log( our_solution );
        })
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    // Menangkap perubahan pada input file
    document.getElementById('image').addEventListener('change', function (e) {
        // Mengupdate label dengan nama file yang dipilih
        var fileName = e.target.files[0].name;
        var label = document.querySelector('.custom-file-label');
        label.innerHTML = fileName;
    });
</script>
{{-- <script>
    $(document).ready(function () {
        // Handle Add Existing Technology button click
        $('#addExistingTechnologyButton').on('click', function () {
            var selectedTechnologyId = $('#existingTech').val();

            // Send AJAX request to add existing technology to the portofolio
            $.ajax({
                url: '{{ route('portofolio-add-technology', $portofolio->id) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    technology_id: selectedTechnologyId
                },
                success: function (data) {
                    // Close the modal
                    $('#addTechnologyModal').modal('hide');

                    // Refresh the page or update the view with the new technology added to the portofolio
                    location.reload();
                },
                error: function (xhr) {
                    // Handle errors, display them to the user
                    console.log(xhr.responseText);
                    alert('Failed to add technology. Please try again.');
                }
            });
        });
    });
</script> --}}
@endsection
