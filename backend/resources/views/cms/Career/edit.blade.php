@extends('layouts.master')

@section('content')
<style>
        .dropdown-menu {
    min-width: 240px;
    max-height: 240px;
    overflow-y: auto;
    }
    .table-qualification{
        min-width: 500px;
        width: auto;
        max-width: 800px;
    }
    .partner-button {
  margin:0.5em 1em 0 0;
}
.job_quali_select{
    display: none;
    width: 0;
    height: 0;
}
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Career</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('career') }}">Career</a></li>
                    <li class="breadcrumb-item active">Edit Career</li>
                </ol>
            </div>
        </div>
    </div>

    <div id="info-message" class="mt-3">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <style>
        .qualification-field {
            display: none;
        }
    </style>

    <div class="container">
        <div class="mt-3">
            <form action="{{ route('career-update', $career->id) }}" method="post" id="careerEditForm">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="positionName">Position Name</label>
                    <input type="text" class="form-control" id="positionName" name="name_position" value="{{ $career->name_position }}" required>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <select class="form-control" id="location" name="location">
                        <option value="Bandung">Bandung</option>
                        <option value="Jakarta">Jakarta</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="desc" rows="5" required>{{ $career->desc }}</textarea>
                </div>

                <div class="form-group">
                    <label for="responsibilities">Responsibilities</label>
                    <textarea class="form-control" id="responsibilities" name="responsibilities" rows="5" required>{{ $career->responsibilities }}</textarea>
                </div>

                <input class="job_quali_select" type="radio" value="{{$career->jobs_qualification_id}}" checked name="jobs_qualification_id">
                <a class="show-job-qualification btn btn-success" data-qualification="{{$career->jobQualification}}">Show Job Qualification</a>

                 <div class="mx-auto job-qualification-section">
                </div>

                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="text" class="form-control" id="link" name="link" value="{{ $career->link }}">
                </div>



            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
        </form>


            <div class="form-group">
                <div class="card-body">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="text-title">Skill</h5>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addSkillModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <ul>
                    @foreach ($career->skillRequirements as $skill)
                    <li class="pb-3">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                {{ $skill->name }}
                            </div>
                            <div class="d-flex">
                                <a role="button" type="button" class="far fa-edit btn-sm btn-outline-primary" data-toggle="modal" data-target="#editSkillModal{{ $skill->id }}"></a>
                                <a role="button" type="submit" class="far fa-trash-alt btn-sm btn-outline-danger" data-toggle="modal" data-target="#DeleteSkillModal{{ $skill->id }}"></a>
                            </div>
                        </div>
                    </li>


                    <!-- Modal editskill -->
                    <div class="modal fade" id="editSkillModal{{ $skill->id }}" tabindex="-1" aria-labelledby="editSkillModalLabel{{ $skill->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSkillModalLabel">Edit Skill</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="{{ route('edit-skill', ['career_id' => $career->id, 'skill_id' => $skill->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="editSkillName">Skill Name</label>
                                            <input type="text" class="form-control" id="editSkillName" name="name" value="{{ $skill->name }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end Modal editskill -->

                    <!-- Modal delete skill -->
                    <div class="modal fade" id="DeleteSkillModal{{ $skill->id }}" tabindex="-1" aria-labelledby="confirmDeleteSkillModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteSkillModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>{{ $skill->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <form method="POST" action="{{ route('delete-skill', ['career_id' => $career->id, 'skill_id' => $skill->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  end Modal delete skill -->
                    @endforeach
                </ul>
            </div>

            <div class="form-group">
                <div class="card-body">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="text-title">Plus Value</h5>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPlusValueModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <ul>
                    @foreach ($career->jobPlusValues as $plusValue)
                    <li class="pb-3">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                {{ $plusValue->name }}
                            </div>
                            <div class="d-flex">
                                <a role="button" type="button" class="far fa-edit btn-sm btn-outline-primary" data-toggle="modal" data-target="#editPlusValueModal{{ $plusValue->id }}"></a>
                                <a role="button" type="submit" class="far fa-trash-alt btn-sm btn-outline-danger" data-toggle="modal" data-target="#confirmDeleteModal{{$plusValue->id}}"></a>
                            </div>
                        </div>
                    </li>
                    <!-- Modal edit plus value -->
                    <div class="modal fade" id="editPlusValueModal{{ $plusValue->id }}" tabindex="-1" aria-labelledby="editPlusValueModalLabel{{ $plusValue->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPlusValueModalLabel">Edit Plus Value</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="{{ route('edit-plus-value', ['career_id' => $career->id, 'plusvalue_id' => $plusValue->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for "editPlusValueName">Name</label>
                                            <input type="text" class="form-control" id="editPlusValueName" name="name" value="{{ $plusValue->name }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir modal edit plus value -->

                    <!-- Modal delete plus value Hapus -->
                    <div class="modal fade" id="confirmDeleteModal{{ $plusValue->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>{{ $plusValue->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <form method="POST" action="{{ route('delete-plus-value', ['career_id' => $career->id, 'plusvalue_id' => $plusValue->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal delete plus End -->
                    @endforeach

                    <!-- Modal untuk menambahkan plus value -->
                    <div class="modal fade" id="addPlusValueModal" tabindex="-1" aria-labelledby="addPlusValueModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPlusValueModalLabel">Add Plus Value</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                                <div class="modal-body">
                                    <!-- Form untuk menambahkan skill -->
                                    <form action="{{ route('career.add-plusValue', $career->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="plusvalue_name">Plus Value Name</label>
                                            <input type="text" class="form-control" id="plusvalue_name" name="plusvalue_name" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Plus Value</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- end Modal untuk menambahkan plus value -->
            </div>
        </div>
    </div>
</div>
</form>
<div class="modal-footer">
</div>





<!-- Modal untuk menambahkan skill -->
<div class="modal fade" id="addSkillModal" tabindex="-1" aria-labelledby="addSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSkillModalLabel">Add Skill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambahkan skill -->
                <form action="{{ route('career.add-skill', $career->id) }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="skill_name">Skill Name</label>
                        <input type="text" class="form-control" id="skill_name" name="skill_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Skill</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Modal untuk mMengupadate career -->
<div class="modal fade" id="updateCareerModal" tabindex="-1" aria-labelledby="updateCareerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCareerModalLabel">Update Career</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambahkan skill -->
                <form action="{{ route('career-update', $career->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="career_name">Are you sure the data is updated?</label>
                    </div>
                    <button class="btn btn-primary" id="careerUpdateButton">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk menambahkan skill -->
<div class="modal fade" id="addSkillModal" tabindex="-1" aria-labelledby="addSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSkillModalLabel">Add Skill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambahkan skill -->
                <form action="{{ route('career.add-skill', $career->id) }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="skill_name">Skill Name</label>
                        <input type="text" class="form-control" id="skill_name" name="skill_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Skill</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
<script>
$(document).ready(function () {

    $('.show-job-qualification').click(function (e) {
        e.preventDefault();
        var data = $(this).data('qualification');
        $('.job-qualification-section').append(`
        <div class="btn-group dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        Job Qualification
                      </button>
                      <div class="dropdown-menu">
                        @foreach($jobQualification as $quali)
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="radio" id="job_qualification_id{{$quali->id}}" name="jobs_qualification_id" class="partner-button dropdown-item" data-partner="{{$quali}}" value="{{$quali->id}}" {{($career->jobs_qualification_id == $quali->id)?'checked':''}}>
                            </div>
                            <div class="col-sm-8">
                                <label for="job_qualification_id{{$quali->id}}">Job Qualification {{$quali->id}}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    </div>
                  <table class="table-qualification table mx-auto" >
                    <thead class="thead-dark"><tr><th colspan="3" class="text-center job-name">Job Qualification `+data.id+`</th></tr></thead>
                    <tbody class="border border-dark mb-2">
                        <tr>
                            <td>Gender</td>
                        <td>:</td>
                        <td class="gender">`+data.gender+`</td>
                    </tr>
                        <tr>
                            <td>Domicile</td>
                        <td>:</td>
                        <td class="domicile">`+data.domicile+`</td>
                    </tr>
                    <tr>
                        <td>Education</td>
                        <td>:</td>
                        <td class="education">`+data.education+`</td>
                    </tr>
                    <tr>
                        <td>Major</td>
                        <td>:</td>
                        <td class="major">`+data.major+`</td>
                    </tr>
                        <tr>
                            <td>Other</td>
                            <td>:</td>
                            <td class="other">`+data.other+`</td>
                        </tr>
                    </tbody>
                </table>
        `)
        $(this).remove();
        $('.job_quali_select').remove();
    })

        $(document).on('click', '.partner-button', function(){
        var partner = $(this).data('partner');

        // Mengisi nilai tabel dengan sesuai
        $('.table-qualification .job-name').text("Job Qualification "+ partner.id);
        $('.table-qualification .gender').text( partner.gender);
        $('.table-qualification .domicile').text(partner.domicile);
        $('.table-qualification .education').text( partner.education);
        $('.table-qualification .major').text(partner.major);
        $('.table-qualification .other').text(partner.other);
    })})
</script>
<script>
    // Cari elemen pesan sukses
    var successMessage = document.getElementById('info-message');

    // Periksa apakah pesan sukses ada
    if (successMessage) {
        // Sembunyikan pesan sukses setelah 5 detik
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000); // 5000 milidetik (5 detik)
    }
</script>

@endsection
