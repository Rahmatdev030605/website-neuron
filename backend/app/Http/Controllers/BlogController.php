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
use App\Models\EditRecord;

class BlogController extends Controller
{
    public function blog()
    {
        return view('cms.Blog.blog');
    }

    public function showblog(Request $request)
    {
        $search = $request->input('search'); // Ambil nilai dari input pencarian

        // Jika ada parameter pencarian, lakukan pencarian berdasarkan nama atau deskripsi
        if ($search) {
            $blogs = Article::where('title', 'like', '%' . $search . '%')
                ->get();
        } else {
            // Jika tidak ada parameter pencarian, ambil semua data portofolio
            $blogs = Article::all();
        }

        return view('cms.Blog.blog', compact('blogs'));
    }

    public function deleteBlog($id)
    {
        Article::where('user_id', $id)->delete();

        $blogs = Article::findOrFail($id);
        $blogName = $blogs->title;
        $blogs->delete();
        deleteRec('Blog', Auth::id(), Auth::user()->role_id, $blogName);
        return redirect()->route('blog')->with('success', 'Blog has been deleted successfully.');
    }

    public function create()
    {
        $categories = ArticleCategory::all();
        return view('cms.Blog.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'desc' => 'required',
            'articles_categories_id' => 'required|exists:articles_categories,id',
            'body' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $profilePicture = $request->file('image');
            $profilePictureName = $profilePicture->getClientOriginalName();
            $profilePicture->move('img/blog', $profilePictureName);
            $profilePicturePath = '/img/blog/' . $profilePictureName;
        }

        // Simpan data blog ke database
        $blog = new Article([
            'title' => $request->title,
            'desc' => $request->desc,
            'articles_categories_id' => $request->articles_categories_id,
            'body' => $request->body,
            'author' => $request->author,
            'image' => url($profilePicturePath)
        ]);

        // Mengisi 'user_id' dengan ID pengguna yang sedang login
        $blog->user_id = Auth::id();

        $blog->save();
        addRec('Blog', Auth::id(), Auth::user()->role_id, $blog->title);
        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('blog')->with('success', 'Blog added successfully.');
    }

    public function viewBlog($id)
    {
        $blog = Article::findOrFail($id);

        return view('cms.Blog.view', compact('blog'));
    }

    public function edit($id)
    {
        //! CATEGORY ARTICLE
        $groupCategories = 
        $categories = ArticleCategory::all();
        $blog = Article::findOrFail($id);
        return view('cms.Blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $blog = Article::findOrFail($id);

        // Validasi data yang akan diupdate
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'desc' => 'required',
            'articles_categories_id' => 'required|exists:articles_categories,id',
            'body' => 'required|string',
            'author' => 'required'
        ]);

        // Update data portofolio
        $blog->title = $request->input('title');
        $blog->desc = $request->input('desc');
        $blog->articles_categories_id = $request->input('articles_categories_id');
        $blog->body = $request->input('body');
        $blog->author = $request->input('author');

        // Periksa apakah ada file gambar yang diupload
        if ($request->hasFile('image')) {
            // Proses gambar baru jika ada
            $imageBlog = $request->file('image');
            $imageBlogName = $imageBlog->getClientOriginalName();
            $imageBlog->move('img/blog', $imageBlogName);
            $imageBlogPath = '/img/blog/' . $imageBlogName;

            // Update path gambar portofolio
            $blog->image = url($imageBlogPath);
        }

        // Mengisi 'user_id' dengan ID pengguna yang sedang login
        $blog->user_id = Auth::id();

        // Simpan perubahan
        $blog->save();
        // editEdRec('Blog', Auth::id(), Auth::user()->role_id, $blog);
        // Redirect ke halaman portofolio dengan pesan sukses
        return redirect()->route('blog')->with('success', 'Blog updated successfully.');
    }

    //API
    public function getBlog(Request $request)
    {
        $category = $request->input('category');

        $query = Article::query();

        if ($category) {
            //! ARTICLE CATEGORY
            $query->whereHas('articleCategory', function ($query) use ($category) {
                $query->where('name', $category);
            });
        }

        $blogs = $query->get();

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
