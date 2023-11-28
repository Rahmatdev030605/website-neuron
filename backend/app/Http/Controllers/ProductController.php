<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

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
    {try{
        $products = Product::findOrFail($id);
        $products->delete();
        deleteRec('Product', Auth::id(), Auth::user()->role_id, $products->name);
        return redirect()->route('product')->with('success', 'Product has been deleted successfully.');
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

    public function create()
    {
        return view('cms.Product.add');
    }

    public function store(Request $request)
    {try{
        // Validasi data yang diterima dari formulir
       $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'link' => 'string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $product = new Product();
        $product['title'] = $validatedData['name'];
        $product->desc = $validatedData['desc']; // Ensure you set 'desc'
        $product->link = $validatedData['link']; // Ensure you set 'desc'
        // Ensure you set 'desc'
        if($request->hasFile('image')){
            $productImage = $request->file('image');
            $productImageName = Uuid::uuid4().$productImage->getClientOriginalName();
            $productImagePath = '/img/product/'. $productImageName;
            $product['image'] = url($productImagePath);
            if($product->save()){
                $productImage->move('img/product', $productImageName);
            }
        }
        // Simpan data portofolio ke database
        $products = new Product([
            'name' => $request->name,
            'desc' => $request->desc,
            'link' => $request->link,
            'images' => $request->image
        ]);

        $products->save();
        addRec('Product', Auth::id(), Auth::user()->role_id, $products->name);
        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return redirect()->route('product')->with('success', 'Product added successfully.');
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('cms.Product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'desc' => 'required|string',
                'link' => 'string|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $product = Product::findOrFail($id);
            $productBefore = clone $product;

            // Use 'title' consistently
            $product->title = $validatedData['name'];

            if ($request->hasFile('image')) {
                $productImage = $request->file('image');
                $productImageName = Uuid::uuid4() . $productImage->getClientOriginalName();
                $productImagePath = 'img/product/' . $productImageName;

                // Update the image path
                $oldImagePath = public_path('img/product/' . basename($product->image));
                $product->image = $productImagePath;

                if ($product->save()) {
                    $productImage->move('img/product', $productImageName);

                    // Delete the old image if it exists and it's not the same as the new image
                    if (File::exists($oldImagePath) && $oldImagePath !== $productImagePath) {
                        File::delete($oldImagePath);
                    }
                }
            } else {
                // If there is no image, just save the pro$product without updating the image
                $product->save();
            }

            editRec('Product', Auth::id(), Auth::user()->role_id, $productBefore, $product, $productBefore->name);
            return redirect()->route('product')->with('success', 'Product Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

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
