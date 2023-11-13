@extends('layouts.master')

@section('content')
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

    <div id="success-message" class="mt-3">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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
            <form action="{{ route('career-store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="positionName">Position Name</label>
                    <input type="text" class="form-control" id="positionName" name="name" required>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <select class="form-control" id="location" name="location" requi>
                        <option value="Bandung">Bandung</option>
                        <option value="Jakarta">Jakarta</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="desc" rows="5" required></textarea>
                </div>

                <div class="form-group">
                    <label for="responsibilities">Responsibilities</label>
                    <textarea class="form-control" id="responsibilities" name="responsibilities" rows="5" required></textarea>
                </div>



                <div class="form-group">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="skillRequirements">Skill Requirement</label>
                                <button type="button" class="btn btn-success addSkillRequirement">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="skillRequirementsContainer">
                                <!-- Initial input field for skill -->
                                <div class="skill-input">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control" name="skillRequirements[]" placeholder="Skill" required>
                                        <button type="button" class="btn btn-danger ml-2 removeSkillRequirement">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="plusvalue">Plus Value</label>
                                <button type="button" class="btn btn-success addPlusValue">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="plusValueContainer">
                                <!-- Initial input field for Plus Value -->
                                <div class="plus-value-input">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control" name="plusValues[]" placeholder="Plus Value" required>
                                        <button type="button" class="btn btn-danger ml-2 removePlusValue">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label for="link">Link</label>
                    <input type="text" class="form-control" id="link" name="link">
                </div>

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

                <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary float-right">Add</button>
            </form>
        </div>
    </div>



</div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Add Skill Requirement
        $(document).on("click", ".addSkillRequirement", function() {
            var newSkillField = '<div class="skill-input">';
            newSkillField += '<div class="d-flex align-items-center">';
            newSkillField += '<input type="text" class="form-control" name="skillRequirements[]" placeholder="Skill" required>';
            newSkillField += '<button type="button" class="btn btn-danger removeSkillRequirement"><i class="fas fa-minus"></i></button>';
            newSkillField += '</div>';
            newSkillField += '</div>';
            $("#skillRequirementsContainer").append(newSkillField);
        });

        // Remove Skill Requirement
        $(document).on("click", ".removeSkillRequirement", function() {
            $(this).closest(".skill-input").remove();
        });
    });
</script>


<script>
    $(document).ready(function () {
        // Add Plus Value
        $(document).on("click", ".addPlusValue", function () {
            var newPlusValueField = '<div class="plus-value-input">';
            newPlusValueField += '<div class="d-flex align-items-center">';
            newPlusValueField += '<input type="text" class="form-control" name="plusValues[]" placeholder="Plus Value" required>';
            newPlusValueField += '<button type="button" class="btn btn-danger ml-2 removePlusValue"><i class="fas fa-minus"></i></button>';
            newPlusValueField += '</div>';
            newPlusValueField += '</div>';
            $("#plusValueContainer").append(newPlusValueField);
        });

        // Remove Plus Value
        $(document).on("click", ".removePlusValue", function () {
            $(this).closest(".plus-value-input").remove();
        });
    });
</script>


<script>
    $(document).ready(function() {
        var skillContainer = $('#skill-container');

        $('#button-skill').click(function() {
            var newInput = $('<input type="text" class="form-control" name="skillRequirements[]" placeholder="Skill" required>');
            skillContainer.append(newInput);
        });
    });
</script>
<script>
    $(document).ready(function() {
        var plusValueContainer = $('#plusValue-container');

        $('#button-plusValue').click(function() {
            var newInput = $('<input type="text" class="form-control" id="jobPlusValues" name="jobPlusValues[]" placeholder="Plus Value">');
            plusValueContainer.append(newInput);
        });
    });
</script>
@endsection
