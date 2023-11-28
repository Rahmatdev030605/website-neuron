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
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Career</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('career') }}">Career</a></li>
                    <li class="breadcrumb-item active">Add Career</li>
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
            <form action="{{ route('career-store') }}" method="POST" class="form-qualification">
                @csrf
                <div class="form-group">
                    <label for="positionName">Position Name</label>
                    <input type="text" class="form-control" id="positionName" name="name" required>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="desc" rows="5" required></textarea>
                </div>

                <div class="form-group">
                    <label for="responsibilities">Responsibilities</label>
                    <textarea class="form-control" id="responsibilities" name="responsibilities" rows="5" required></textarea>
                </div>

                <div class="mx-auto">
                    <div class="btn-group dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        Job Qualification
                      </button>
                      <div class="dropdown-menu">
                        @foreach($jobQualification as $quali)
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="radio" id="job_qualification_id{{$quali->id}}" name="jobs_qualification_id" class="partner-button dropdown-item" data-partner="{{$quali}}" value="{{$quali->id}}">
                            </div>
                            <div class="col-sm-8">
                                <label for="job_qualification_id{{$quali->id}}">Job Qualification {{$quali->id}}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    </div>
                  <table class="table-qualification table mx-auto" >
                    <thead class="thead-dark"><tr><th colspan="3" class="text-center job-name">Job Qualification </th></tr></thead>
                    <tbody class="border border-dark mb-2">
                        <tr>
                            <td>Gender</td>
                        <td>:</td>
                        <td class="gender"></td>
                    </tr>
                        <tr>
                            <td>Domicile</td>
                        <td>:</td>
                        <td class="domicile"></td>
                    </tr>
                    <tr>
                        <td>Education</td>
                        <td>:</td>
                        <td class="education"></td>
                    </tr>
                    <tr>
                        <td>Major</td>
                        <td>:</td>
                        <td class="major"></td>
                    </tr>
                        <tr>
                            <td>Other</td>
                            <td>:</td>
                            <td class="other"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

                <div class="form-group" id="skill-container">
                    <div class="d-flex">
                        <label for="skillRequirements">Skill Requirement</label>
                        <button type="button" class="btn btn-primary ml-auto" id="button-skill">Add Skill</button>
                    </div>
                    <div class="d-flex text-middle" id="skillRequirements">
                            <input type="text" class="form-control"  name="skillRequirements[]" placeholder="Skill" required >
                            <a class="far fa-trash-alt btn-sm btn-outline-danger" onclick="removeElement('skillRequirements')"></a>
                    </div>
                </div>

                <div class="form-group" id="plusValue-container">
                    <div class="d-flex">
                        <label for="jobPlusValues">Plus Value</label>
                        <button type="button" class="btn btn-primary ml-auto" id="button-plusValue">Add Plus Value</button>
                    </div>
                    <div class="d-flex" id="jobPlusValues">
                        <input type="text" id="plusValue" class="form-control"  name="jobPlusValues[]" placeholder="Plus Value">
                        <a class="far fa-trash-alt btn-sm btn-outline-danger" onclick="removeElement('jobPlusValues')"></a>
                    </div>
                </div>

                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="text" class="form-control" id="link" name="link">
                </div>

                <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary float-right submit-form-dat">Add</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var i = 0;
    $(document).ready(function () {
        var skillContainer = $('#skill-container');

        $('#button-skill').click(function () {
            var newInput = $(`<div class="d-flex text-middle" id="skillRequirements`+i+`">
                            <input type="text" class="form-control"  name="skillRequirements[]" placeholder="Skill" required onclick="remove">
                            <a class="far fa-trash-alt btn-sm btn-outline-danger" onclick="removeElement('skillRequirements`+i+`')"></a>
                    </div>`);
            skillContainer.append(newInput);
            i++
        });
    });
</script>
<script>
    var a = 0;
    $(document).ready(function () {
        var plusValueContainer = $('#plusValue-container');

        $('#button-plusValue').click(function () {
            var newInput = $(`<div class="d-flex" id="jobPlusValues`+a+`">
                        <input type="text" id="plusValue" class="form-control"  name="jobPlusValues[]" placeholder="Plus Value">
                        <a class="far fa-trash-alt btn-sm btn-outline-danger" onclick="removeElement('jobPlusValues`+a+`')"></a>
                    </div>`);
            plusValueContainer.append(newInput);
            a++
        });
    });
</script>
<script>
    $(document).ready(function () {
    $('.partner-button').click(function (e) {

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
<script>
    function removeElement(elementId){
        var categoryElement = document.getElementById(elementId);
        categoryElement.remove();
    }
</script>
@endsection
