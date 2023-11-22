@extends('layouts.master')

@section('content')
<style>
            #category-check{
            pointer-events: none;
            width: 0px;
            height: 0px;
        }
        .item-of-dropdown{
    min-width: 240px;
    max-height: 240px;
    overflow-y: auto;
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><strong>Add Blog</strong> </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminpanel') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></li>
                    <li class="breadcrumb-item active">Add Blog</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div id="success-message" class="mt-3">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('store-blog') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" id="author" name="author" >
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" >
                    </div>

                    <div class="form-group">
                        <label for="desc">Description</label>
                        <input type="text" class="form-control" id="desc" name="desc" >
                    </div>

                    <div class="form-group">
                        <label for="articles_categories_id">Category</label>
                        <div id="category-container" class="border border-secondary p-2 rounded">
                            <strong><span class="ml-1 badge badge-secondary border border-dark align-middle" id="categoryExample">
                                <input id="category-check" type="checkbox" value="Example" disabled name="categoryNew[]" checked
                                style="visibility: hidden" >Example
                                <a class="btn-outline-light rounded-circle p-1 fas fa-times delete-category" onclick="removeCategory('categoryExample')"></a>
                            </span></strong>
                        </div>
                        <div class="w-50 float-right container align-middle">
                            <div class="row float-right category-section mt-2">

                                <div class="col-sm-5">
                                        <div class="btn-group dropleft">
                                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Add Category
                                            </a>
                                        <div class="dropdown-menu">
                                            <div class="item-of-dropdown">
                                                @foreach($categories as $category)
                                                <a class="dropdown-item button-category-exist" data-category="{{ $category->name }}" data-category-id="{{$category->id}}">{{ $category->name }}</a>
                                                @endforeach
                                            </div>
                                            <div class="dropdown-divider"></div>
                                            <button class="dropdown-item button-new-category rounded bg-primary"><i class="fas fa-plus"></i>' Add Category</button>
                                        </div>
                                    </div>
                                </div>

                             </div>
                        </div>
                    </div>
                </br>

                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea class="ckeditor form-control" id="body" name="body"></textarea>
                    </div>

                    <a href="{{ route('blog') }}" class="btn btn-primary">Back</a>
                    <button type="submit" class="btn btn-primary float-right">Add Blog</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .then( editor => {
            console.log( body );
        })
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    var categoryArrayNew = [];
    var categoryArrayExist = [];
    $(document).ready(function (e) {
        var categoryContainer = $('#category-container');

        $(document).on('click','.button-category-exist', function () {
            var category = $(this).data('category');
            var categoryId = $(this).data('category-id');
            var elementId = 'category-exist-' + categoryId;
            var newInput = $('<strong id="'+elementId+'"><span class="mx-1 my-1 badge badge-light border border-dark align-middle"><input type="checkbox" id="category-check"name="categoryExist[]" checked style="visibility: hidden" value="'+categoryId+'">'
                +category
                +'<a class="btn-outline-secondary rounded-circle p-1 fas fa-times" onclick="removeCategory(\''+elementId+'\',\''+category+'\')"></a></span></strong>');
            categoryArrayExist.push(categoryId);
            categoryContainer.append(newInput);
            $(this).remove();
        });

        $(document).on('click','.button-category-new', function () {
            var category = $(this).data('category');
            var elementId = 'category-new-' + categoryArrayNew.length;
            var newInput = $('<strong id="'+elementId+'"><span class="mx-1 my-1 badge badge-light border border-dark align-middle"><input type="checkbox" id="category-check" name="categoryNew[]" checked style="visibility: hidden" value="'+category+'">'
                +category
                +'<a class="btn-outline-secondary rounded-circle p-1 fas fa-times" onclick="removeCategory(\''+elementId+'\',\''+category+'\')"></a></span></strong>');
            categoryArrayNew.push(category);
            categoryContainer.append(newInput);
            $(this).remove();
        });

        $(document).on( 'click', '.new-category-form-add', function(e){
            e.preventDefault();
            var newCategory = $('.new-category-form').val();
            var elementId = 'category-new-' + categoryArrayNew.length;
            var newInput = $('<strong id="'+elementId+'"><span class="mx-1 my-1 badge badge-light border border-dark align-middle"><input type="checkbox" id="category-check" name="categoryNew[]" checked style="visibility: hidden" value="'+newCategory+'">'
                +newCategory
                +'<a class="btn-outline-secondary rounded-circle p-1 fas fa-times" onclick="removeCategory(\''+elementId+'\',\''+newCategory+'\')"></a></span></strong>');
            categoryArrayNew.push(newCategory);
            categoryContainer.append(newInput);
            $('.col-new-category').remove()
            $('.button-new-category').removeAttr('disabled');
        })


    $('.button-new-category').click(function (e) {
        e.preventDefault();
        $('.category-section').append(`
        <div class="col-sm-7 col-new-category input-group input-group-sm mb-3">
            <input type="text" class="form-control new-category-form" placeholder="New Category...." aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-success new-category-form-add" type="button">Add</button>
            </div>
        </div>
        `);
        $('.button-new-category').attr('disabled', 'disabled')
        });
    });

    function removeCategory(categoryElementId, categoryName){
        var categoryElement = document.getElementById(categoryElementId);
        var dropdownSection = $('.item-of-dropdown')
        if(categoryElement && categoryElementId.includes('exist')){
            var categoryId = categoryElementId.match(/\d+/);
            dropdownSection.append(`
            <a class="dropdown-item button-category-exist" data-category="`+categoryName+`" data-category-id="`+categoryId+`">`+categoryName+`</a>
            `)
            // Remove the category element
            categoryElement.remove();
        }else if(categoryElement && categoryElementId.includes('new')){
            if (categoryName) {
                dropdownSection.append(`
                <a class="dropdown-item button-category-new" data-category="`+categoryName+`">`+categoryName+`</a>
                `)
                // Remove the category element
                categoryElement.remove();
            }
        }
    }
</script>
@endsection
