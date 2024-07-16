<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index',[
            'products' => Product::all(),
            'sections' => Section::all(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $attributes = $request->validated();
        Product::create($attributes);
        return redirect()->route('admin.products.index')->with('success','تم إنشاء المنتج بنجاح');
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $attributes = $request->validated();
        $product->update($attributes);
        return redirect()->route('admin.products.index')->with('success','تم تعديل المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success','تم حذف المنتج بنجاح');
    }
}
