<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Models\ArticleCategoryGroup;
use App\Models\EditRecord;
use Illuminate\Support\Facades\Auth;

class BlogCategoryController extends Controller
{
    public function blogcategories()
    {
        return view('cms.Blog.Categories.categories');
    }

    public function blogcategoriesshow(Request $request)
    {
        $categories = ArticleCategory::with('articleCategoryGroup')->get();
        return dd($categories);
        return view('cms.Blog.Categories.categories', compact('categories'));
    }

    public function deleteBlogCategory($id)
    {
        try {
            //code...
        $category = ArticleCategory::findOrFail($id); // Assuming Category is the model for categories

        if ($category) {

            ArticleCategoryGroup::where('category_id', $category->id)->delete();
            // Delete the category
            $category->delete();

            //Data For Record
            deleteRec('Blog Category', Auth::id(), Auth::user()->role_id, $category->name);
            return redirect()->route('blog-categories')->with('success', 'Category deleted successfully');
        } else {
            return redirect()->route('blog-categories')->with('error', 'Category not found');
        }
        } catch (\Throwable $th) {
            return redirect()->route('blog-categories')->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        $categories = ArticleCategory::all();
        return view('cms.Blog.Categories.add', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            //code...
        $request->validate([
            'name' => 'required'
        ]);

        // Simpan data blog ke database
        $category = new ArticleCategory([
            'name' => $request->name
        ]);

        $category->save();
        addRec('Blog Category', Auth::id(), Auth::user()->role_id, $category->name);
        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('blog-categories')->with('success', 'Blog Categories added successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('blog-categories')->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $category = ArticleCategory::findOrFail($id);
        return view('cms.Blog.Categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            //code...
        $category = ArticleCategory::findOrFail($id);

        // Validasi data yang akan diupdate
        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        // Update data portofolio
        $categoryBefore = clone $category;
        $category->name = $request->input('name');
        $category->save();
        editRec('Blog Category', Auth::id(), Auth::user()->role_id, $categoryBefore, $category, $categoryBefore->name);
        // Redirect ke halaman portofolio dengan pesan sukses
        return redirect()->route('blog-categories')->with('success', 'Blog category updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('blog-categories')->with('error', $th->getMessage());
        }
    }
}
