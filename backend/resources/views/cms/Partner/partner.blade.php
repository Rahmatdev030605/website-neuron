@extends('layouts.master')

@section('content')
<style>
    .partner-img{
        width: auto;
        max-width: 200px;
        height: inherit;
    }
    .partner-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Partner</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item active">Partner</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="mt-3">
            <form action="{{route('partner')}}" method="POST">
                @csrf
                @method('GET')
                <div class="input-group" style="width: 100%;">
                    <input type="text" class="form-control" name="search" placeholder="Search...">
                    <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                </form>
                        @if(auth()->user()->role->role_name !== 'HCM')
                        <a data-toggle="modal" data-target="#addPartnerModal" class="btn btn-success ml-5">Add Partner</a>
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
        <div class="partner-grid mx-auto">
            @foreach($partners as $partner)
            <div class="card mx-3" style="width: 18rem;">
                <div class="card-header mx-auto d-flex justify-content-center align-items-center">
                    <img class="card-img-top partner-img pt-2 px-2" src="{{$partner->image}}" alt="image of partner">
                </div>
                <div class="col-sm mb-2 mx-auto card-body">
                    <div class="row justify-content-center mb-4 ">
                    <h3 class="card-title text-bold">{{$partner->name}}</h3>
                    </div>
                    <div class="row mx-auto">
                        <div class="row mx-auto btn-group">
                                <button class="btn btn-sm btn-primary edit-btn"
                                data-partner="{{$partner}}"
                                data-toggle="modal"
                                data-target="#editPartnerModal"
                                >Edit</button>

                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-partner-for-del="{{$partner}}"
                                    data-toggle="modal"
                                    data-target="#deletePartnerModal"
                                >Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
        <div class="mx-auto">
            {{$partners->links('pagination::bootstrap-4')}}
        </div>


        <!-- Modal Add Partner -->
        <div class="modal fade" id="addPartnerModal" tabindex="-1" aria-labelledby="addPartnerModal" aria-hidden="true">
            <div class="modal-dialog modal-m">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewPortofolioModalLabel">Add Partner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('partner-store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <div class="mx-auto">
                                    <img class="partner-img partner-img-modal" src="" alt="Partner Image">
                                </div>
                            <label for="image">Image</label>
                            <input type="file" class="form-control" accept="image/*" name="image" id="image">
                            </div>

                            <div class="form-group mt-4">
                                <label for="name">Partner Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Akhir modal Add Partner -->

        <!-- Modal Edit Partner -->
        <div class="modal fade" id="editPartnerModal" tabindex="-1" aria-labelledby="editPartnerModal" aria-hidden="true">
            <div class="modal-dialog modal-m">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewPortofolioModalLabel">Edit Partner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="partner-edit" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div class="mx-auto">
                                    <img class="partner-img partner-img-modal" src="" alt="Partner Image">
                                </div>
                            <label for="image">Image</label>
                            <input type="file" class="form-control" accept="image/*" name="image" id="image">
                            </div>

                            <div class="form-group mt-4">
                                <label for="name">Partner Name</label>
                                <input type="text" class="form-control" id="name" name="name" required value="">
                            </div>
                            <button type="submit" class="btn btn-success">Edit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Akhir modal Edit Partner -->

        <!-- Modal Delete Partner -->
        <div class="modal fade" id="deletePartnerModal" tabindex="-1" aria-labelledby="deletePartnerModal" aria-hidden="true">
            <div class="modal-dialog modal-m">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewPortofolioModalLabel">Delete Partner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center  ">
                        <form class="align-items-center mx-auto" id="partner-delete" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mx-auto">
                                <img class="partner-img img-modal-delete" src="" alt="Partner Image">
                            </div>
                            <p>are you sure you want to delete <strong></strong></p>
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Akhir modal Delete Partner -->
    </div>
</div>
</div>

{{-- SCRIPT UNTUK DELETE MODAL --}}
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function (event) {
            var partner = $(this).data('partner-for-del');
            // Set the value for the delete form action
            $('#partner-delete').attr('action','/partner/'+partner.id+'/delete');

            // Update the text in the modal body
            $('#deletePartnerModal').find('.modal-body').find('.img-modal-delete').attr('src', partner.image);
            $('#deletePartnerModal').find('.modal-body').find('strong').text(partner.name);
        });
    });
</script>

{{-- SCRIPT UNTUK UPDATE --}}
<script>
    $(document).ready(function() {
        // Menggunakan selector dengan class "edit-btn"
        $('.edit-btn').on('click', function (event) {
            var button = $(this);
            var partnerData = button.data('partner');

            // Ganti action URL form dengan URL edit berdasarkan partnerId
            var editForm = $('#partner-edit');
            editForm.attr('action', '/partner/' + partnerData.id + '/update');

            // Setel nilai src dan nama di form edit
            editForm.find('.form-group .mx-auto .partner-img-modal').attr('src', partnerData.image);
            editForm.find('.form-group #name').val(partnerData.name);
        });
    });
</script>
@endsection
