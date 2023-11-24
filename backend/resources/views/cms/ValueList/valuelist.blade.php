@extends('layouts.master')

@section('content')


<style>
    .valuelist-img {
        width: auto;
        max-width: 200px;
        height: inherit;
    }

    .valuelist-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
</style>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Value List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item active">Value List</li>
                </ol>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="mt-3">
            <form action="" method="POST">
                @csrf
                @method('GET')
                <div class="input-group" style="width: 100%;">
                    <input type="text" class="form-control" name="search" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
            </form>
            @if(auth()->user()->role->role_name !== 'HCM')
            <a data-toggle="modal" data-target="#addValueListModal" class="btn btn-success ml-5">Add Value List</a>
            @else
            <button class="btn btn-success ml-5" disabled>Add Portfolio</button>
            @endif
        </div>
    </div>

    <div id="success-message" class="mt-3">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
    </div>

    <div id="error-message" class="mt-3">
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
    </div>
    <div class="row mt-3">
        <div class="valuelist-grid mx-auto">
            @foreach($valuelists as $valuelist)
            <div class="card mx-3" style="width: 18rem;">
                <div class="card-header mx-auto d-flex justify-content-center align-items-center">
                    <img class="card-img-top valuelist-img pt-2 px-2" src="{{$valuelist->image}}" alt="image of value list">
                </div>
                <div class="col-sm mb-2 mx-auto card-body">
                    <div class="row justify-content-center mb-4 ">
                        <h3 class="card-title text-bold mr-2">{{ $valuelist->title }}</h3>
                        <h3 class="card-title ">{{ $valuelist->desc }}</h3>
                    </div>
                    <div class="row mx-auto">
                        <div class="row mx-auto btn-group">
                            <button class="btn btn-sm btn-primary edit-btn" data-valuelist="{$valuelist}" data-toggle="modal" data-target="#editValueListModal">Edit</button>

                            <button class="btn btn-sm btn-danger delete-btn" data-valuelist-for-del="{$valuelist}" data-toggle="modal" data-target="#deleteValueListModal">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mx-auto">
    {{$valuelists->links('pagination::bootstrap-4')}}
    </div>

    <!-- Modal Add  -->
    <div class="modal fade" id="addValueListModal" tabindex="-1" aria-labelledby="addPartnerModal" aria-hidden="true">
        <div class="modal-dialog modal-m">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPortofolioModalLabel">Add Value List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('store-value-list')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <div class="mx-auto">
                                <img class="partner-img partner-img-modal" src="" alt="Value List Image">
                            </div>
                            <label for="image">Image</label>
                            <input type="file" class="form-control" accept="image/*" name="image" id="image">
                        </div>

                        <div class="form-group mt-4">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group mt-4">
                            <label for="name">Description</label>
                            <input type="text" class="form-control" id="desc" name="desc" required>
                        </div>
                        <div class="form-group mt-4">
                            <label for="name">ID</label>
                            <input type="text" class="form-control" id="about_id" name="about_id" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir modal Add ValueList -->
</div>

<!-- Modal Edit Value LIst -->
<div class="modal fade" id="editValueListModal" tabindex="-1" aria-labelledby="editValueListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-m">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editValueListModalLabel">Edit Value List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($valuelists as $valuelist)
                <form id="valuelist-edit" action="{{ route('update-value-list', ['id' => $valuelist->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <div class="mx-auto">
                            <img class="value-list-img value-list-img-modal" src="" alt="ValueList Image">
                        </div>
                        <label for="image">Image</label>
                        <input type="file" class="form-control" accept="image/*" name="image" id="image">
                    </div>

                    <div class="form-group mt-4">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title', $valuelist->title) }}">
                    </div>

                    <div class="form-group mt-4">
                        <label for="desc">Description</label>
                        <input type="text" class="form-control" id="desc" name="desc" required value="{{ old('desc', $valuelist->desc) }}">
                    </div>
                    <button type="submit" class="btn btn-success">Edit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
                @endforeach
            </div>
        </div>
    </div>
</div>

</div>
<!-- Akhir modal Edit Partner -->

<!-- Modal Delete Partner -->

<div class="modal fade" id="deleteValueListModal" tabindex="-1" aria-labelledby="deleteValueListModal" aria-hidden="true">
    <div class="modal-dialog modal-m">
        @foreach($valuelists as $valuelist)
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewValueListModalLabel">Delete Value List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form class="align-items-center mx-auto" id="valuelist-delete" action="{{ route('delete-value-list', ['id' => $valuelist->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="mx-auto">
                        <img class="value-list-img img-modal-delete" src="{{$valuelist->image}}" alt="Value-List Image">
                    </div>
                    <p>are you sure you want to delete <strong>{{ $valuelist->title }}</strong></p>
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Akhir modal Delete Partner -->
</div>
</div>
</div>

{{-- SCRIPT UNTUK DELETE MODAL --}}
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function(event) {
            var partner = $(this).data('valuelist-for-del');
            // Set the value for the delete form action
            $('#valuelist-delete').attr('action', '/valuelist/' + valuelist.id + '/delete');

            // Update the text in the modal body
            $('#deleteValueListModal').find('.modal-body').find('.img-modal-delete').attr('src', valuelist.image);
            $('#deleteValueListModal').find('.modal-body').find('strong').text(valuelist.name);
        });
    });
</script>

{{-- SCRIPT UNTUK UPDATE --}}
<script>
    $(document).ready(function() {
        // Menggunakan selector dengan class "edit-btn"
        $('.edit-btn').on('click', function(event) {
            var button = $(this);
            var partnerData = button.data('valuelist');

            // Ganti action URL form dengan URL edit berdasarkan partnerId
            var editForm = $('#valuelist-edit');
            editForm.attr('action', '/valuelist/' + valuelist.id + '/update');

            // Setel nilai src dan nama di form edit
            editForm.find('.form-group .mx-auto .value-list-img-modal').attr('src', valuelistData.image);
            editForm.find('.form-group #title').val(valuelist.title);
        });
    });
</script>

@endsection
