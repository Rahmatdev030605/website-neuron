@extends('layouts.master')

@section('content')

<style>
    .modal-body {
        position: relative;
    }

    .delete-button {
        position: absolute;
        right: 1;
        /* Menempatkan tombol di sudut kanan atas */
        background-color: #ff0000;
        /* Warna latar belakang tombol */
        color: #fff;
        /* Warna teks tombol */
        border: none;
        padding: 5px 10px;
        /* Atur padding sesuai kebutuhan Anda */
        cursor: pointer;
    }
</style>

<div class="form-group">
    <div class="card-body">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-title"> <strong>Job Qualification</strong> </h5>
                <div class="modal-footer d-flex justify-content-end">
                    <a href="{{ route('career.add-jobQualification') }}" class="btn btn-success"><i class="fas fa-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
    @foreach($JobQualifications as $Qualification)
    <div class="modal-body">
        <form action="{{ route('career.update-jobQualification', ['id' => $Qualification->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <ul><h2>Job Qualification {{$Qualification->id}}</h2>
                <li class="pb-3">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Man" {{ $Qualification->gender == 'Man' ? 'selected' : '' }}>Man</option>
                            <option value="Female" {{ $Qualification->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Man/Female" {{ $Qualification->gender == 'Man/Female' ? 'selected' : '' }}>Man/Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="domicile">Domicile</label>
                        <input type="text" class="form-control" id="domicile" name="domicile" value="{{ $Qualification->domicile }}" required>
                    </div>

                    <div class="form-group">
                        <label for="education">Education</label>
                        <input type="text" class="form-control" id="education" name="education" value="{{ $Qualification->education }}" required>
                    </div>

                    <div class="form-group">
                        <label for="major">Major</label>
                        <input type="text" class="form-control" id="major" name="major" value="{{ $Qualification->major }}" required>
                    </div>

                    <div class="form-group">
                        <label for="other">Other Qualifications</label>
                        <input type="text" class="form-control" id="other" name="other" value="{{ $Qualification->other }}" required>
                    </div>
                    <button class="btn btn-danger delete-button" data-toggle="modal" data-target="#confirmDeleteModal{{$Qualification->id}}"><i class="fas fa-trash"></i></button>
                </li>
            </ul>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('career') }}" class="btn btn-secondary" data-dismiss="modal">Close</a>
            </div>
        </form>
    </div>

    <!-- Modal delete Job Qualification  -->
    <div class="modal fade" id="confirmDeleteModal{{$Qualification->id}}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong>Job Qualification {{$Qualification->id}}</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <form method="POST" action="{{ route('career.delete-jobQualification', ['id' => $Qualification->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Modal delete plus End -->
</div>
<script>
    $(document).on( 'click', '.delete-button', function(e){e.preventDefault();})
</script>
@endsection
