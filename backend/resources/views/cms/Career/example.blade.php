<div class="modal-content" id="editJobQualificatinModal{{ $jobqualification->id }}" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
          <div class="modal-header">
            <h5 class="modal-title">Job Qualification</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <strong>Edit Job Qualification</strong>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="Man" {{ $career->jobQualification->gender == 'Man' ? 'selected' : '' }}>Man</option>
                    <option value="Female" {{ $career->jobQualification->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Man/Female" {{ $career->jobQualification->gender == 'Man/Female' ? 'selected' : '' }}>Man/Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="domicile">Domicile</label>
                <input type="text" class="form-control" id="domicile" name="domicile" value="{{ $career->jobQualification->domicile }}" required>
            </div>

            <div class="form-group">
                <label for="education">Education</label>
                <input type="text" class="form-control" id="education" name="education" value="{{ $career->jobQualification->education }}" required>
            </div>

            <div class="form-group">
                <label for="major">Major</label>
                <input type="text" class="form-control" id="major" name="major" value="{{ $career->jobQualification->major }}" required>
            </div>

            <div class="form-group">
                <label for="other">Other Qualifications</label>
                <input type="text" class="form-control" id="other" name="other" value="{{ $career->jobQualification->other }}" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
          </div>
        </div>




        @foreach ($jobqualifications as $jobqualification)
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    {{ $jobqualification->gender }}
                                </div>
                                <div>
                                    {{ $jobqualification->domicile }}
                                </div>
                                <div>
                                    {{ $jobqualification->education }}
                                </div>
                                <div>
                                    {{ $jobqualification->major }}
                                </div>
                                <div>
                                    {{ $jobqualification->other }}
                                </div>
                            </div>
                            @endforeach
