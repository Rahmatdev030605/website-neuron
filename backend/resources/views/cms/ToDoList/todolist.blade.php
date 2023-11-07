<style>
    .toggle-desc-button .text {
        display: none;
    }

    .toggle-desc-button:hover .text {
        display: block;
    }

    .todo-item .description {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s;
    }
</style>

<div class="card">
    {{-- HEADER --}}
    <div class="card-header">
        <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            To Do List
        </h3>
            <a href="{{ route('adminpanel.todolist.create') }}" name="adminpanel.todolist.create" class="btn btn-primary float-right">
            <i class="fas fa-plus"></i> Add item</a>
    </div>

    {{-- BODY --}}
    <div class="card-body">
        <ul class="todo-list" data-widget="todo-list">
            @if(isset($todos))
            @foreach($todos as $todo)
            <li class="todo-item">
                <!-- drag handle -->
                <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                </span>
                <!-- checkbox -->
                <!-- checkbox -->
                <div class="icheck-primary d-inline ml-2">
                    <input type="checkbox" value="{{ $todo->id }}" name="todo{{ $todo->id }}" id="todoCheck{{ $todo->id }}">
                    <label for="todoCheck{{ $todo->id }}"></label>
                </div>

                <!-- todo text -->
                <span class="text">{{ $todo->title }}</span>
                <!-- Emphasis label -->
                <small class="badge badge-danger "><i class="far fa-clock toggle-desc"></i> {{ $todo->date_start }}</small>
                <!-- General tools such as edit or delete-->

                <div class="tools">
                    <a href="{{ route('adminpanel.todolist.edit', ['todolist' => $todo->id]) }}"><i class="fas fa-edit"></i></a>
                    <i class="fas fa-trash-o"></i>
                </div>

                <ul class="nav nav-treeview desc-list">
                    <li class="nav-item ">
                        <div class="toggle-desc-button">
                            <span class="text desc-list" style="opacity: 0.6; font-size: 12px; margin-left: 73px;">{{ $todo->desc }}</span>
                        </div>
                    </li>
                </ul>

            </li>
            @endforeach
            @endif
        </ul>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.desc-list').hide();

        $('.todo-item').click(function() {
            var description = $(this).find('.desc-list');
            description.slideToggle();
        });
    });
</script>
<!-- /
