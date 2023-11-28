@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Blog</strong></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item active">Blog</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="container">
        <div class="mt-3">
            <form action="{{ route('show-blog') }}" method="GET">
                @csrf
                <div class="input-group" style="width: 100%;">
                    <input type="text" class="form-control" name="search" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                    @if(auth()->user()->role->role_name !== 'HCM')
                        <a href="{{ route('create-blog') }}" class="btn btn-success ml-5">Add Blog</a>
                    @else
                        <button class="btn btn-success ml-5" disabled>Add Blog</button>
                    @endif
                </div>
            </form>
        </div>

        <form action="{{route('show-blog')}}" class="w-50 mt-3" method="POST">
            @csrf
            @method('GET')
            <select name="filter" id="filter" class="btn btn-outline-secondary text-left">
                <option selected value="">All</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}" {{($filter == $category->id)?'selected':''}}>{{$category->name}}</option>
                @endforeach
            </select>
            <select name="sort" id="sort" class="btn btn-outline-secondary text-left ml-2">
                <option selected>Sort By</option>
                <option value="ascending" {{($sort == "ascending") ? 'selected' : ''}}>A-Z</option>
                <option value="descending" {{($sort == "descending") ? 'selected' : ''}}>Z-A</option>
                <option value="newest" {{($sort == "newest" ) ? 'selected' : ''}}>Newest</option>
                <option value="oldest" {{($sort == "oldest" ) ? 'selected' : ''}}>Oldest</option>
            </select>

            <button type="submit" class="btn btn-info ml-2">Apply</button>
        </form>

        <div id="success-message" class="mt-3">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div id="success-message" class="mt-3">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="row mt-3">
            <style>
                .blog-grid {
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                .blog-card {
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    margin: 10px;
                    padding: 20px;
                    max-width: 400px;
                    background-color: white;
                }

                .blog-img {
                    max-width: 100%;
                    width: 100%;
                    object-fit: cover;
                    margin-bottom: 10px;
                }

                .blog-head {
                    display: flex;
                    align-items: center;
                    margin-bottom: -10px;
                }

                .blog-category {
                    font-size: 20px;
                    font-weight: bold;
                }

                .blog-date {
                    font-size: 15px;
                    color: #777;
                    padding-top: 12px;
                    padding-left: 4px;
                }

                .card-title {
                    font-size: 25px;
                    font-weight: bold;
                    /* margin-bottom: px; */
                }

                .card-text {
                    font-size: 14px;
                    color: #333;
                }
            </style>
            <div class="blog-grid">
                @foreach($blogs as $blog)
                <div class="blog-card">
                    <div class="blog-head">
                        <h6 class="blog-category">{{$blog->author}} | </h6>
                        <p class="blog-date">{{ $blog->created_at->format('d/m/Y') }}</p>
                    </div>
                    <img class="blog-img" src="{{ asset($blog->image) }}" alt="{{ $blog->image }}">
                    <div id="category-container" >
                        @foreach ($blog->articleCategoryGroups as $cateGroup)
                        <strong><span class="ml-0 badge badge-danger border border-dark align-middle" id="categoryExample">
                            {{$cateGroup->articleCategory->name}}
                        </span></strong>
                        @endforeach
                        </div>
                    <h5 class="card-title">{{ $blog->title }}</h5>
                    <p class="card-text">{{\Illuminate\Support\Str::limit ($blog->desc, 95) }}</p>
                    <div class="float-right">
                        @if(auth()->user()->role->role_name !== 'HCM')
                            <a href="{{ route('blog-edit', $blog->id) }}" class="btn btn-success">Edit</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $blog->id }}">Delete</button>
                        @else
                            <button class="btn btn-success" disabled>Edit</button>
                            <button class="btn btn-danger" disabled>Delete</button>
                        @endif
                        <a href="{{ route('view-blog', ['id' => $blog->id]) }}" class="btn btn-primary">View</a>
                    </div>
                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="confirmDeleteModal{{ $blog->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>{{ $blog->title }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <form id="delete-form-{{ $blog->id }}" action="{{ route('delete-blog', $blog->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Konfirmasi Hapus End -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    // Cari elemen pesan sukses
    var successMessage = document.getElementById('success-message');

    // Periksa apakah pesan sukses ada
    if (successMessage) {
        // Sembunyikan pesan sukses setelah 5 detik
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000); // 5000 milidetik (5 detik)
    }
</script>
@endsection
