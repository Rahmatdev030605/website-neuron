@extends('layouts.master')

@section('content')

<style>
    /* Add appropriate styling for the button and icon */
    .save-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 15px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        background-color: #3490dc; /* Primary color, adjust as needed */
        color: #ffffff; /* Text color, adjust as needed */
        cursor: pointer;
        position: relative;

    .save-button i {
        font-size: 18px;
    }

    /* Add a hover effect */
    .save-button:hover {
        background-color: #09032b; /* Darker shade or different color, adjust as needed */
    }

    /* Style for form groups */


    .loading {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
}
</style>

<div class="form-group">
    <div class="card-body">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="text-title">
                    <strong>Add New To Do Item</strong>
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('adminpanel.todolist.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="desc" id="desc" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="date_start">Start Date</label>
                        <input type="datetime-local" name="date_start" id="date_start" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="date_end">End Date</label>
                        <input type="datetime-local" name="date_end" id="date_end" class="form-control" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary save-button" id="saveButton">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <div id="loading" class="loading"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#saveButton').on('click', function () {
            // Tampilkan elemen loading
            $('#loading').show();

            // Sisipkan fungsi-fungsi AJAX atau pemrosesan data di sini
            // Gantilah bagian ini sesuai dengan logika aplikasi Anda

            setTimeout(function () {
                // Sembunyikan elemen loading setelah selesai pemrosesan data atau AJAX
                $('#loading').hide();
            }, 5000); // Contoh: Setelah 5 detik, gantilah dengan durasi yang sesuai
        });
    });

</script>

@endsection
