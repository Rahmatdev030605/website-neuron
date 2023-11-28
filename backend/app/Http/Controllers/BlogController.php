<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticlePages;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BlogDetailResource;
use App\Http\Resources\ArticlePagesResource;
use App\Models\ArticleCategoryGroup;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;
class BlogController extends Controller
{
    public function blog()
    {
        return view('cms.Blog.blog');
    }

    public function showblog(Request $request)
    {

        $search = $request->input('search'); // Ambil nilai dari input pencarian
        $filter = $request->input('filter'); // Ambil nilai dari input filter
        $sort = $request->input('sort'); // Ambil nilai dari input sort

        $blogs = Article::with(['articleCategoryGroups.articleCategory', 'user']);

        // Jika ada parameter pencarian, lakukan pencarian berdasarkan nama atau deskripsi
        if ($search) {
            $blogs->where('title', 'like', '%' . $search . '%');
        }

        if ($filter) {
            $blogs->whereHas('articleCategoryGroups.articleCategory', function ($query) use ($filter) {
                $query->where('id', $filter);
            });
        }

        $blogs = $blogs->get();

        switch($sort){
            case 'ascending':
                $blogs = $blogs->sortBy('title');
                break;
            case 'descending':
                $blogs = $blogs->sortByDesc('title');
                break;
            case 'newest':
                $blogs = $blogs->sortByDesc('created_at');
                break;
            case 'oldest':
                $blogs = $blogs->sortBy('created_at');
                break;
            default:
                $blogs = $blogs->sortBy('title');;
                break;
        }
        $categories = ArticleCategory::all();


        return view('cms.Blog.blog', compact('blogs','categories', 'filter', 'sort'));
    }

    public function deleteBlog($id)
    {
        try {
        $blogs = Article::findOrFail($id);
        $oldImageNamePath = public_path('img/blog/' . basename($blogs['image']));
        $blogName = $blogs->title;
        ArticleCategoryGroup::where('article_id', $blogs->id)->delete();
        if($blogs->delete()){
            //jika berhasil maka akan mengapus image yang digunakan portofolio juga
            if(File::exists($oldImageNamePath)){
                File::delete($oldImageNamePath);
            }
        };
        deleteRec('Blog', Auth::id(), Auth::user()->role_id, $blogName);
        return redirect()->route('blog')->with('success', 'Blog has been deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('blog')->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        $categories = ArticleCategory::all();
        return view('cms.Blog.add', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            //code...
            // return dd($request->all());
        $dataBlog = $request->validate([
            'title' => 'required|max:255',
            'desc' => 'required',
            'body' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required',
            'categoryExist' => 'required|array',
            'categoryNew' => 'nullable|array'
        ]);

        // Simpan data blog ke database
        $blog = new Article([
            'title' => $request->title,
            'desc' => $request->desc,
            'body' => $request->body,
            'author' => $request->author,
        ]);
        // Mengisi 'user_id' dengan ID pengguna yang sedang login
        $blog->user_id = Auth::id();

        $profilePicture = $request->file('image');
        $profilePictureName = Uuid::uuid4() .  $profilePicture->getClientOriginalName();
        $profilePicturePath = '/img/blog/' . $profilePictureName;
        $blog['image'] = url($profilePicturePath);

        $blog->save();

        $profilePicture->move('img/blog', $profilePictureName);

        // Memasukkan kategori yang sudah ada sebelumnya ke category group
        foreach($dataBlog['categoryExist'] as $exist){
            ArticleCategoryGroup::create([
                'article_id' => $blog->id,
                'category_id' => $exist
            ]);
        }

        //Jika ada category baru maka akan membuat category baru lalu memasukkannya ke category group
        if(isset($validatedData['categoryNew']) && is_array($validatedData['categoryNew'])){
            foreach($dataBlog['categoryNew'] as $new){
                $newCate = ArticleCategory::create([
                    'name' => $new
                ]);
                ArticleCategoryGroup::create([
                    'article_id' => $blog->id,
                    'category_id' => $newCate->id
                ]);
            }
        }

        addRec('Blog', Auth::id(), Auth::user()->role_id, $blog->title);
        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('blog')->with('success', 'Blog added successfully.');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

    public function viewBlog($id)
    {
        try {
            //code...
            $blog = Article::findOrFail($id);
            return view('cms.Blog.view', compact('blog'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $categories = ArticleCategory::all();
        $blog = Article::findOrFail($id);
        return view('cms.Blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            //code...

        $blog = Article::findOrFail($id);
        $blogBefore = clone $blog;

        // Validasi data yang akan diupdate
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'desc' => 'required',
            'body' => 'required|string',
            'author' => 'required',
            'categoryExist' => 'required|array',
            'categoryNew' => 'nullable|array'
        ]);
        // Update data portofolio
        $blog->title = $request->input('title');
        $blog->desc = $request->input('desc');
        $blog->body = $request->input('body');
        $blog->author = $request->input('author');
        // Mengisi 'user_id' dengan ID pengguna yang sedang login
        $blog->user_id = Auth::id();

        // Periksa apakah ada file gambar yang diupload
        if ($request->hasFile('image')) {
            // Proses gambar baru jika ada
            $imageBlog = $request->file('image');
            $imageBlogName = Uuid::uuid4() .  $imageBlog->getClientOriginalName();
            $imageBlogPath = '/img/blog/' . $imageBlogName;

            // Mengambil nama yang lama untuk bahan perbandingan
            $oldImageNamePath = public_path('img/blog/' . basename($blog['image']));
            // Update path gambar portofolio
            $blog->image = url($imageBlogPath);
            if($blog->save()){
                $imageBlog->move('img/blog', $imageBlogName);
                if(File::exists($oldImageNamePath)&&!(basename($oldImageNamePath) == $imageBlogName)){
                    File::delete($oldImageNamePath);
                }
            }
        }else{
            // Simpan perubahan
            $blog->save();
        }

        // Menghapus Category Group yang lama karena terdapat perubahan
        ArticleCategoryGroup::where('article_id', $blog->id)->delete();
        // Memasukkan kategori yang sudah ada sebelumnya ke category group
        foreach ($validatedData['categoryExist'] as $key => $category) {
            ArticleCategoryGroup::create([
                'article_id' => $blog->id,
                'category_id' => $category
            ]);
        }

        //Jika ada category baru maka akan membuat category baru lalu memasukkannya ke category group
        if(isset($validatedData['categoryNew']) && is_array($validatedData['categoryNew'])){
            foreach($validatedData['categoryNew'] as $new){
                $newCate = ArticleCategory::create([
                    'name' => $new
                ]);
                ArticleCategoryGroup::create([
                    'article_id' => $blog->id,
                    'category_id' => $newCate->id
                ]);
            }
        }
        editRec('Blog', Auth::id(), Auth::user()->role_id, $blogBefore, $blog, $blogBefore->title);
        // Redirect ke halaman portofolio dengan pesan sukses
        return redirect()->route('blog')->with('success', 'Blog updated successfully.');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

    //API
    public function getBlog(Request $request)
    {

        $search = $request->input('search'); // Ambil nilai dari input pencarian
        $filter = $request->input('filter'); // Ambil nilai dari input filter
        $sort = $request->input('sort'); // Ambil nilai dari input sort

        $blogs = Article::with(['articleCategoryGroups.articleCategory', 'user']);

        // Jika ada parameter pencarian, lakukan pencarian berdasarkan nama atau deskripsi
        if ($search) {
            $blogs->where('title', 'like', '%' . $search . '%');
        }

        if ($filter) {
            $blogs->whereHas('articleCategoryGroups.articleCategory', function ($query) use ($filter) {
                $query->where('id', $filter);
            });
        }

        $blogs = $blogs->get();

        switch($sort){
            case 'ascending':
                $blogs = $blogs->sortBy('title');
                break;
            case 'descending':
                $blogs = $blogs->sortByDesc('title');
                break;
            case 'newest':
                $blogs = $blogs->sortByDesc('created_at');
                break;
            case 'oldest':
                $blogs = $blogs->sortBy('created_at');
                break;
            default:
                $blogs = $blogs->sortBy('title');;
                break;
        }

        if ($blogs->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Blogs not found'
            ], 404);
        }

        return BlogResource::collection($blogs);
    }

    public function getBlogById($id)
    {
        $blog = Article::findOrFail($id);

        return new BlogDetailResource($blog);
    }

    public function getBlogPages()
    {
        $blogPages = ArticlePages::all();

        return ArticlePagesResource::collection($blogPages);
    }

    public function getLatestBlog()
    {
        $latestBlogs = Article::orderBy('created_at', 'desc')->take(5)->get();

        return BlogResource::collection($latestBlogs);
    }
}
