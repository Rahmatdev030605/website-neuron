@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Career</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item active">Career</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="container">
        <div class="mt-3">
            <form action="{{ route('show-career') }}" method="GET">
                @csrf
                <div class="input-group" style="width: 100%;">
                    <input type="text" class="form-control" name="search" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                    <a href="{{ route('career-create') }}" class="btn btn-success ml-5">Add Career</a>
                    <a href="{{ route('career.get-jobQualification') }}" class="btn btn-primary ml-2">Job Qualification</a>
                </div>
            </form>
        </div>

        <div id="success-message" class="mt-3">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="accordion mt-3" style="background-color: white;" id="careerAccordion">
            @foreach($careers as $career)
                <div data-toggle="collapse" data-target="#collapse{{ $career->id }}" aria-expanded="true" aria-controls="collapse{{ $career->id }}">
                    <div class="card-header" id="heading{{ $career->id }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <h5 class="font-weight-bold" style="font-size: 25px;">{{ $career->name_position }}</h5>
                            </div>

                            <div class="d-flex">
                                <h5 class="font-weight-bold mr-5" style="font-size: 25px;">{{ $career->location }}</h5>
                                <a href="{{ route('career-edit', $career->id) }}" class="btn btn-success mr-1">Edit</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $career->id }}">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Konfirmasi Hapus -->
                <div class="modal fade" id="confirmDeleteModal{{ $career->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <strong>{{ $career->name_position }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <form id="delete-form-{{ $career->id }}" action="{{ route('delete-career', $career->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Yes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Konfirmasi Hapus End -->
            @endforeach
        </div>
    </div>
</div>
<!-- Sertakan file JavaScript Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Cari elemen pesan sukses
    var successMessage = document.getElementById('success-message');

    // Periksa apakah pesan sukses ada
    if (successMessage) {
        // Sembunyikan pesan sukses setelah 5 detik
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000); // 5000 milidetik (5 detik)
    }
</script>
<script>
    // Fungsi untuk menampilkan modal saat tombol "Edit" diklik
    function openEditSkillModal(skillId) {
        var modalId = 'editSkillModal' + skillId;
        var modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
    }

    // Fungsi untuk menampilkan modal saat tombol "Delete" diklik
    function openConfirmDeleteModal(careerId) {
        var modalId = 'confirmDeleteModal' + careerId;
        var modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
    }
</script>
@endsection
