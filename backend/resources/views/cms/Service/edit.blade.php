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
            </div><!-- /.col    
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
                    <form action="{{ route('service-update', $service->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $service->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control" id="desc" name="desc" required>{{ $service->desc }}</textarea>
                        </div>


                        <div class="form-group">
                            <div class="d-flex">
                            </div>

                        </div>


                        <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </form>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir dari modal key feature -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script>
    $(document).ready(function () {
        // Handle Add Existing Technology button click
        $('#addExistingTechnologyButton').on('click', function () {
            var selectedTechnologyId = $('#existingTech').val();

            // Send AJAX request to add existing technology to the service
            $.ajax({
                url: '{{ route('keyfeature-add-technology', $service->id) }}',
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
</script> -->
@endsection
