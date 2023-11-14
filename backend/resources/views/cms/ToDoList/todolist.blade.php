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

    .badge, .date-start {
        font-size: 20px;
    }
</style>

<div class="card">
    {{-- HEADER --}}
    <div class="card-header">
        <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            To Do List
        </h3>
        <div class="card-tools">
            <ul class="pagination pagination-sm">
                <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                <li class="page-item"><a href="#" class="page-link 1">1</a></li>
                <li class="page-item"><a href="#" class="page-link">2</a></li>
                <li class="page-item"><a href="#" class="page-link">3</a></li>
                <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
            </ul>
        </div>
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
                    <input type="checkbox" value="{{ $todo->id }}" name="todo{{ $todo->id }}" id="todoCheck{{ $todo->id }}" data-deadline="{{ $todo->date_end }}">
                    <label for="todoCheck{{ $todo->id }}"></label>
                </div>

                <!-- todo text -->
                <span class="text">{{ $todo->title }}</span>
                <!-- Emphasis label -->
                <small class="badge badge-danger" data-end="{{ $todo->date_end }}"><i class="far fa-clock toggle-desc"></i> Deadline {{ $todo->date_end }}</small>
                <span class="date-start" data-start="{{ $todo->date_start }}"><i class="far fa-clock toggle-desc"></i> Start {{ $todo->date_start }}</span>
                <!-- General tools such as edit or delete-->

                <div class="tools">
                    <a href="{{ route('adminpanel.todolist.edit', ['todolist' => $todo->id]) }}"><i class="fas fa-edit"></i></a>
                    <i class="fas fa-trash-o"></i>
                </div>

                <ul class="nav nav-treeview desc-list">
                    <li class="nav-item ">
                        <div class="toggle-desc-button">
                            <span class="text" style="font-size: 12px; padding-left: 67px ">{{ $todo->desc }}</span>
                            </div>
                    </li>
                </ul>

            </li>
            @endforeach
            @endif
        </ul>

        <div class="card-footer clearfix">
            <a href="{{ route('adminpanel.todolist.create') }}" name="adminpanel.todolist.create" class="btn btn-primary float-right">
            <i class="fas fa-plus"></i> Add item</a>
        </div>
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
<script>
    // Ambil semua elemen checkbox dengan atribut 'data-deadline'
    const checkboxes = document.querySelectorAll('input[data-deadline]');

    checkboxes.forEach((checkbox) => {
        const deadline = new Date(checkbox.getAttribute('data-deadline'));
        const currentDate = new Date();

        // Bandingkan tanggal `date_end` dengan tanggal saat ini
        if (deadline < currentDate) {
            checkbox.checked = true;
        }
    });
</script>

<script>
    function deleteExpiredTodos() {
        const checkboxes = document.querySelectorAll('input[data-deadline]');

        checkboxes.forEach((checkbox) => {
            const deadline = new Date(checkbox.getAttribute('data-deadline'));
            const currentDate = new Date();

            if (deadline < currentDate) {
                // Hapus elemen list tugas (parent dari checkbox)
                const todoItem = checkbox.parentElement.parentElement;
                todoItem.remove();
            }
        });
    }

    // Pemeriksaan pertama saat halaman dimuat
    deleteExpiredTodos();

    // Mengeksekusi pemeriksaan setiap 1 menit (atau sesuai kebutuhan)
    setInterval(deleteExpiredTodos, 60000); // Setiap 1 menit
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dateStartElements = document.querySelectorAll(".date-start");
        const dateEndElements = document.querySelectorAll(".badge-danger");

        dateStartElements.forEach((startElement, index) => {
            const startDate = new Date(startElement.dataset.start);
            const endDate = new Date(dateEndElements[index].dataset.end);

            const timeDifference = endDate - startDate;
            const daysDifference = timeDifference / (1000 * 3600 * 24);

            if (daysDifference <= 3) {
                startElement.style.color = "red"; // Ubah warna teks menjadi merah
            } else if (daysDifference <= 7) {
                startElement.style.color = "yellow"; // Ubah warna teks menjadi kuning
            } else {
                startElement.style.color = "green"; // Atau warna hijau, sesuai kebutuhan
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Fungsi untuk menyesuaikan ukuran font
        function adjustFontSize(element) {
            var maxFontSize = 20; // Ukuran font maksimal yang diizinkan
            var minFontSize = 12; // Ukuran font minimal yang diizinkan
            var originalText = element.text();
            var textLength = originalText.length;

            // Hitung ukuran font yang sesuai dengan panjang teks
            var fontSize = maxFontSize / (textLength / 10);

            // Batasi ukuran font antara nilai minimal dan maksimal
            fontSize = Math.max(minFontSize, Math.min(maxFontSize, fontSize));

            // Atur ukuran font elemen
            element.css('font-size', fontSize + 'px');
        }

        // Panggil fungsi untuk badge dan span saat dokumen dimuat
        adjustFontSize($('.badge'));
        adjustFontSize($('.date-start'));
    });
</script>









    <!-- /
