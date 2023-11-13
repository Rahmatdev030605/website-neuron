@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Portofolio</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item active">Portofolio</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="container">
        <div class="mt-3">
            <form action="{{ route('show-portofolio') }}" method="GET">
                @csrf
                <div class="input-group" style="width: 100%;">
                    <input type="text" class="form-control" name="search" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                    @if(auth()->user()->role->role_name !== 'HCM')
                        <a href="{{ route('portofolio-create') }}" class="btn btn-success ml-5">Add Portfolio</a>
                    @else
                        <button class="btn btn-success ml-5" disabled>Add Portfolio</button>
                    @endif
                </div>
            </form>
        </div>

        {{-- ! FILTER HERE NOT WORKING --}}
        <form action="{{route('portofolio')}}" class="w-50 mt-3" method="POST">
            @csrf
            @method('GET')
            <select name="filter" id="filter" class="btn btn-outline-secondary text-left">
                <option selected>Filter</option>
                @foreach($services as $service)
                <option value="{{$service->id}}" {{($filter == $service->id)?'selected':''}}>{{$service->name}}</option>
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

        {{-- ! END FILTER HERE --}}

        <div id="success-message" class="mt-3">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div id="error-message" class="mt-3">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="row mt-3">
            <style>
                .product-grid {
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                .product-card {
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    margin: 10px;
                    padding: 20px;
                    max-width: 400px;
                    background-color: white;
                }

                .category-container {
                    width: 100%;
                    text-align: end;
                }

                .category {
                    background-color: rgb(185, 28, 28);
                    font-size: 12px;
                    font-weight: medium;
                    color: white;
                    padding: 8px 12px;
                    border-radius: 5px;
                }

                .product-name {
                    font-weight: bold;
                    font-size: 1.25rem;
                }

                .product-customer {
                    text-decoration-line: underline;
                    font-weight: 500;
                    font-size: 14px;
                }

                .product-desc {
                    font-size: 14px;
                }

                .product-date {
                    width: 100%;
                    text-align: end;
                    font-size: 14px;
                }

                .product-img {
                    margin-bottom: 16px;
                    max-height: 208px;
                    width: 100%;
                    object-fit: cover;
                }

                .product-img-modal {
                    margin-bottom: 16px;
                    height: auto;
                    width: 100%;
                    object-fit: cover;
                }

                .technology-card {
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    margin: 5px;
                    padding: 20px;
                    max-width: 400px;
                    background-color: white;
                }

                .deliverable-card{
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    margin: 5px;
                    padding: 20px;
                    max-width: 400px;
                    background-color: white;
                }

                .handle-card{
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    margin: 5px;
                    padding: 20px;
                    max-width: 400px;
                    background-color: white;
                }
            </style>
            <div class="product-grid">
                @foreach($portofolios as $portofolio)
                <div class="product-card">
                    <img class="product-img" src="{{ asset($portofolio->image) }}" alt="{{ $portofolio->name }}" data-toggle="modal" data-target="#viewPortofolioModal{{ $portofolio->id }}">
                    <div>
                        <div class="category-container">
                            <span class="category">{{ $portofolio->category }}</span>
                        </div>
                        <h5 class="product-name">{{ $portofolio->name }}</h5>
                        <h6 class="product-customer">{{ $portofolio->customer_name }}</h6>
                        <p class="product-desc">{{ \Illuminate\Support\Str::limit($portofolio->desc, 200) }}</p>
                        <p class="product-date">{{ $portofolio->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="actions">
                        @if(auth()->user()->role->role_name !== 'HCM')
                            <a href="{{ route('portofolio-edit', $portofolio->id) }}" class="btn btn-success">Edit</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $portofolio->id }}">Delete</button>
                        @else
                            <button class="btn btn-success" disabled>Edit</button>
                            <button class="btn btn-danger" disabled>Delete</button>
                        @endif
                    </div>
                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="confirmDeleteModal{{ $portofolio->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>{{ $portofolio->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <form id="delete-form-{{ $portofolio->id }}" action="{{ route('delete-portofolio', $portofolio->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Konfirmasi Hapus End -->

                    <!-- Modal portofolio -->
                    <div class="modal fade" id="viewPortofolioModal{{ $portofolio->id }}" tabindex="-1" aria-labelledby="viewPortofolioModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewPortofolioModalLabel">View Portofolio</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img class="product-img-modal" src="{{ asset($portofolio->image) }}" alt="{{ $portofolio->name }}">
                                    <div>
                                        <div class="category-container">
                                            <span class="category">{{ $portofolio->category }}</span>
                                        </div>
                                        <h5 class="product-name">{{ $portofolio->name }}</h5>
                                        <h6 class="product-customer">{{ $portofolio->customer_name }}</h6>
                                        <p class="product-desc">{{ $portofolio->desc }}</p>
                                        <h5 class="product-name">Details</h5>
                                        <p class="product-desc">{{ $portofolio->details }}</p>
                                        <h5 class="product-name">Our Solution</h5>
                                        <p class="product-desc">{!! $portofolio->our_solution !!}</p>
                                        <p class="product-date">{{ $portofolio->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content: center;">
                                        <!-- Tampilkan daftar teknologi -->
                                        <div class="technology-card">
                                            <h5 class="text-bold">Technology Used</h5>
                                            <ul style="list-style: none;">
                                                @foreach ($portofolio->portofolioTechnology as $portfolioTech)
                                                    @if ($portfolioTech->technology)
                                                        <li class="pb-3">
                                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                                <div>
                                                                    @if (!empty($portfolioTech->technology->icon))
                                                                        <img src="{{ $portfolioTech->technology->icon }}" alt="{{ $portfolioTech->technology->name }}">
                                                                    @endif
                                                                    {{ $portfolioTech->technology->name }}
                                                                </div>
                                                                <form method="POST" action="{{ route('delete-technology-portofolio', ['portofolio_id' => $portofolio->id, 'technology_id' => $portfolioTech->technology->id]) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    @if(auth()->user()->role->role_name !== 'HCM')
                                                                        <button type="submit" class="btn btn-danger ml-3">Delete</button>
                                                                    @else
                                                                        <button class="btn btn-danger ml-3" disabled>Delete</button>
                                                                    @endif
                                                                </form>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                        <!-- Tampilkan daftar deliverables -->
                                        <div class="deliverable-card">
                                            <h5 class="text-bold">Deliverables</h5>
                                            <ul>
                                                @foreach ($portofolio->deliverables as $deliverable)
                                                <li class="pb-3">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <div>
                                                            {{ $deliverable->name }}
                                                        </div>
                                                        <div>
                                                            <form method="POST" action="{{ route('delete-deliverable', ['portofolio_id' => $portofolio->id, 'deliverable_id' => $deliverable->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                @if(auth()->user()->role->role_name !== 'HCM')
                                                                    <button type="submit" class="btn btn-danger ml-3">Delete</button>
                                                                @else
                                                                    <button type="button" class="btn btn-danger ml-3" disabled>Delete</button>
                                                                @endif
                                                            </form>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <!-- Tampilan daftar handle -->
                                    </div>
                                    <div class="d-flex" style="justify-content: center;">
                                        <div class="handle-card">
                                            <h5 class="text-bold">Handles</h5>
                                            <ul>
                                                @foreach ($portofolio->handles as $handle)
                                                <li class="pb-3">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <div>
                                                            {{ $handle->name }}
                                                        </div>
                                                        <div>
                                                            <form method="POST" action="{{ route('delete-handle', ['portofolio_id' => $portofolio->id, 'handle_id' => $handle->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                @if(auth()->user()->role->role_name !== 'HCM')
                                                                    <button type="submit" class="btn btn-danger ml-3">Delete</button>
                                                                @else
                                                                    <button type="button" class="btn btn-danger ml-3" disabled>Delete</button>
                                                                @endif
                                                            </form>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir modal portofolio -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    // Cari elemen pesan sukses
    var successMessage = document.getElementById('success-message');
    var errorMessage = document.getElementById('error-message');

    // Periksa apakah pesan sukses ada
    if (successMessage) {
        // Sembunyikan pesan sukses setelah 5 detik
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000); // 5000 milidetik (5 detik)
    }
    if (errorMessage) {
        // Sembunyikan pesan sukses setelah 5 detik
        setTimeout(function() {
            errorMessage.style.display = 'none';
        }, 3000); // 5000 milidetik (5 detik)
    }
</script>
@endsection
