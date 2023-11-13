@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-title"><strong>Add Job Qualification</strong></h5>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('career.store-jobQualification') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="Man">Man</option>
                    <option value="Female">Female</option>
                    <option value="Man/Female">Man/Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="domicile">Domicile</label>
                <input type="text" class="form-control" id="domicile" name="domicile" required>
            </div>

            <div class="form-group">
                <label for="education">Education</label>
                <input type="text" class="form-control" id="education" name="education" required>
            </div>

            <div class="form-group">
                <label for="major">Major</label>
                <input type="text" class="form-control" id="major" name="major" required>
            </div>

            <div class="form-group">
                <label for="other">Other Qualifications</label>
                <input type="text" class="form-control" id="other" name="other" required>
            </div>

            <div class="modal-footer">
                <a href="{{ route('career') }}" class="btn btn-secondary">Close</a>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>
@endsection
