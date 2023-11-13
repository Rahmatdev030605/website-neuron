@extends('layouts.master')

@section('content')
<div class="form-group">
    <div class="card-body">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-title"> <strong>Job Qualification</strong> </h5>
                <div class="modal-footer d-flex justify-content-end">
                    <a href="{{ route('career.add-jobQualification') }}" class="btn btn-success"><i class="fas fa-plus"></i></a>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-body">
        @foreach($JobQualifications as $JobQualification)
        <form action="{{ route('career.update-jobQualification', ['id' => $JobQualification->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <ul>
                <li class="pb-3">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Man" {{ $JobQualification->gender == 'Man' ? 'selected' : '' }}>Man</option>
                            <option value="Female" {{ $JobQualification->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Man/Female" {{ $JobQualification->gender == 'Man/Female' ? 'selected' : '' }}>Man/Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="domicile">Domicile</label>
                        <input type="text" class="form-control" id="domicile" name="domicile" value="{{ $JobQualification->domicile }}" required>
                    </div>

                    <div class="form-group">
                        <label for="education">Education</label>
                        <input type="text" class="form-control" id="education" name="education" value="{{ $JobQualification->education }}" required>
                    </div>

                    <div class="form-group">
                        <label for="major">Major</label>
                        <input type="text" class="form-control" id="major" name="major" value="{{ $JobQualification->major }}" required>
                    </div>

                    <div class="form-group">
                        <label for="other">Other Qualifications</label>
                        <input type="text" class="form-control" id="other" name="other" value="{{ $JobQualification->other }}" required>
                    </div>
                </li>
            </ul>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('career') }}" class="btn btn-secondary" data-dismiss="modal">Close</a>
            </div>
        </form>
    </div>

    <!-- Modal delete Job Qualification  -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <form method="POST" action="{{ route('career.delete-jobQualification', [ $JobQualification->id]) }}">
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
@endsection
