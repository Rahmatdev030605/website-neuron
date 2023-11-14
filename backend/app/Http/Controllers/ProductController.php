<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function product()
    {
        return view('cms.Product.product');
    }

    public function showproduct(Request $request)
    {
        $search = $request->input('search'); // Ambil nilai dari input pencarian

        // Jika ada parameter pencarian, lakukan pencarian berdasarkan nama atau deskripsi
        if ($search) {
            $products = Product::where('name', 'like', '%' . $search . '%')
                ->get();
        } else {
            // Jika tidak ada parameter pencarian, ambil semua data portofolio
            $products = Product::all();
        }

        return view('cms.Product.product', compact('products'));
    }

    public function deleteProduct($id)
    {
        $products = Product::findOrFail($id);
        $products->delete();
        deleteRec('Product', Auth::id(), Auth::user()->role_id, $products);

        return redirect()->route('product')->with('success', 'Product has been deleted successfully.');
    }

    public function create()
    {
        return view('cms.Product.add');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'desc' => 'required|string',
            'link' => 'string|max:255',
        ]);

        // Simpan data portofolio ke database
        $products = new Product([
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'desc' => $request->desc,
            'link' => $request->link
        ]);

        $products->save();
        addRec('Product', Auth::id(), Auth::user()->role_id, $products);

        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('product')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('cms.Product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validasi data yang akan diupdate
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'desc' => 'required|string',
            'link' => 'string|max:255',
        ]);

        // Update data product
       $name = $product->name = $request->input('name');
       $subtitle = $product->subtitle = $request->input('subtitle');
       $link = $product->link = $request->input('link');
       $desc =  $product->desc = $request->input('desc');

        // Simpan perubahan
        $product->save();
        editRec('Product', Auth::id(), Auth::user()->role_id, $name, $subtitle, $link, $desc);

        // Redirect ke halaman portofolio dengan pesan sukses
        return redirect()->route('product')->with('success', 'product updated successfully.');
    }

    // API
    public function getProduct()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}
