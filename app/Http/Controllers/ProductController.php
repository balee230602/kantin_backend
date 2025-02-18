<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        //get data products
        $products = DB::table('products')
        ->when($request->input('name'), function ($query, $name){
            return $query->where('name', 'like', '%'.$name.'%');
        })
        ->orderBy('id','desc')
        ->paginate(10);
        return view('pages.products.index',compact('products'));

     }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        $request->validate( [
            'name'=>'required|min:3|unique:products',
           // 'description'=>'required|min:10',
            'price'=>'required|integer',
            'stock'=>'required|integer',
            'category'=>'required|in:food,drink,snack',
            'image'=>'required|image|mimes:png,jpg,jpeg',
        ]);
        $filename= time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);

        $data = $request->all();
        $products = new \App\Models\Product;
        $products->name = $request->name;
        $products->price = (int) $request->price;
        $products->stock = (int) $request->stock;
        $products->category = $request->category;
        $products->image = $filename;
        $products->save();
       //\App\Models\Product::create($data);
        return redirect()->route('product.index')->with('success','product successfully created');
    }

    public function edit($id)
    {
        $products = \App\Models\Product::findOrFail($id);
        return view('pages.products.edit', compact('products'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $products = \App\Models\Product::findOrFail($id);
        $products->update($data);
        return redirect()->route('product.index')->with('success','product successfully updated');
    }

    public function destroy($id)
    {
        $products = \App\Models\Product::findOrFail($id);
        $products->delete();
        return redirect()->route('product.index')->with('success','product successfully deleted');
    }




}

