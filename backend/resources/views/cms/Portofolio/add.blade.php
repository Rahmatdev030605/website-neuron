@extends('layouts.master')

@section('content')


<style>
    /* CSS untuk mempercantik formulir input file */
.form-group {
    margin-bottom: 15px;
}

.label-upload {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.file-input {
    display: none;
}

.custom-file {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.custom-file-label {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    padding: 8px;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    border-radius: 5px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.custom-file-input {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    opacity: 0;
    cursor: pointer;
}

/* Gaya tambahan saat input file terpilih */
.custom-file-input:focus + .custom-file-label,
.custom-file-input.has-file + .custom-file-label {
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.custom-file-input.has-file + .custom-file-label::after {
    content: 'Change';
}


</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Portofolio</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('portofolio') }}">Portofolio</a></li>
                    <li class="breadcrumb-item active">Add Portofolio</li>
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
                    <form action="{{ route('portofolio-store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="service">Service</label>
                            <select type="text" class="form-control" id="service" name="service_id" required>
                                @foreach($services as $service)
                                <option value="{{$service->id}}" {{old('service_id') == $service->id ? 'selected' : ''}}>{{$service->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control" id="desc" name="desc" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="details">Detail</label>
                            <input type="text" class="form-control" id="details" name="details" required></input>
                        </div>

                        <div class="form-group">
                            <label for="our_solution">Solution</label>
                            <textarea class="ckeditor form-control" id="our_solution" name="our_solution"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="created_at">Date</label>
                            <input type="datetime-local" class="form-control" id="created_at" name="created_at" required></input>
                        </div>

                        <div class="form-group">
                            <label for="successProject">Success Project</label>
                            <select class="form-control" id="successProject" name="successProject">
                                @foreach ($successProjectOption as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group" id="deliverables-container">
                            <div class="card-body">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="deliverables">Deliverables</label>
                                        <button class="btn btn-success ml-auto" id="button-deliverable"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>

                            </div>
                            <input type="text" style="margin-bottom: 10px;" class="form-control" id="deliverables" name="deliverables[]" placeholder="Deliverable 1">
                            <input type="text" style="margin-bottom: 10px;" class="form-control" id="deliverables" name="deliverables[]" placeholder="Deliverable 2">
                        </div>

                        <div class="form-group" id="handles-container">
                            <div class="card-body">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="deliverables">Handles</label>
                                        <button class="btn btn-success ml-auto" id="button-deliverable"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>

                            </div>
                            <input type="text" style="margin-bottom: 10px;" class="form-control" id="handles" name="handles[]" placeholder="Handle 1">
                            <input type="text" style="margin-bottom: 10px;" class="form-control" id="handles" name="handles[]" placeholder="Handle 2">
                        </div>

                        <div class="form-group">
                            <label for="image" class="label-upload">Choose an image:</label>
                            <label for="image" class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <span class="custom-file-label">No file chosen</span>
                            </label>
                        </div>

                        <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-primary float-right">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#our_solution'))
        .then(editor => {
            console.log(our_solution);
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    $(document).ready(function() {
        var handlesContainer = $('#handles-container');

        $('#button-handle').click(function() {
            var newInput = $('<input type="text" class="form-control" name="handles[]" placeholder="Handle">');
            handlesContainer.append(newInput);
        });
    });
</script>
<script>
    $(document).ready(function() {
        var handlesContainer = $('#deliverables-container');

        $('#button-deliverable').click(function() {
            var newInput = $('<input type="text" class="form-control" name="deliverables[]" placeholder="Deliverable">');
            handlesContainer.append(newInput);
        });
    });
</script>
@endsection
