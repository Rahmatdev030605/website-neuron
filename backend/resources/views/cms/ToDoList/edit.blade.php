@extends('layouts.master')

@section('content')
<style>
    .right-align {
        float: right;
    }

    .custom-button {
        width: 200px;
        height: 50px;
    }
    .loading-page {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: white;
    z-index: 9999;
}

.custom-button {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s infinite linear;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}


    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>



<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            Edit To Do Item
        </h3>
    </div>
    <div class="card-body">
        <form action="{{ route('adminpanel.todolist.update', $todo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $todo->title }}" required>
            </div>
            <div class="form-group">
                <label for="desc">Description</label>
                <textarea name="desc" id="desc" class="form-control" rows="4" required>{{ $todo->desc }}</textarea>
            </div>
            <div class="form-group">
                <label for="date_start">Start Date</label>
                <input type="datetime-local" name="date_start" id="date_start" class="form-control" value="{{ $todo->date_start }}" required>
            </div>
            <div class="form-group">
                <label for="date_end">End Date</label>
                <input type="datetime-local" name="date_end" id="date_end" class="form-control" value="{{ $todo->date_end }}" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary custom-button" id="saveButton"><i class="fas fa-save"></i> Save Edit
                </button>
            </div>
        </form>

        <form action="{{ route('adminpanel.todolist.destroy', ['todolist' => $todo->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="text-center">
                <button type="submit" class="far fa-trash-alt btn-sm btn-outline-danger right-align" id="deleteButton"></a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    var formattedDateTime = "{{ $todo->date_start }}";
    document.getElementById("date_start").value = formattedDateTime;
</script>

<script>

$(window).on('load', function () {
    setTimeout(function() {
        hideLoadingPage(); // Sembunyikan elemen loading page setelah selesai loading
    }, 1200)
});

function hideLoadingPage() {
    $('#loadingPage').fadeOut();
}
</script>

@endsection


