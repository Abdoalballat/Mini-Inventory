<?php

namespace App\Http\Controllers;


use App\Models\invoice_items;
use App\Models\products;
use App\Http\Requests\product_validate;
use App\Services\ImageKitService;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use View;

class ProductsController extends Controller
{
public function index(Request $request)
{
    $search =$request->input('search');
    $products =products::when($search, function($query,$search)
    {
        $query->where('product_name','like',"%{$search}%");

    })->latest()->paginate(10);
    $bestseller_item = invoice_items::query()
    ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
    ->groupBy('product_id')
    ->orderByDesc('total_sold')
    ->first();
    $best_seller =$bestseller_item ? products::find($bestseller_item->product_id) :null ;
    return view('products.index', compact('products', 'search','best_seller'));
}
    public function create()
    {
        return view('products.create');
        // return redirect()->route('products.create');

    }

    public function store(product_validate $request ,ImageKitService $imageKitService)
    {
$imageUrl = null;

    if ($request->hasFile('image')) {
        $imageUrl = $imageKitService->uploadImage($request->file('image'));
    }

products::create([
    'product_name' => $request->product_name,
    'department'   => $request->department,
    'description'  => $request->description,
    'count'        => $request->count,
    'price'        => $request->price,
    'image'        => $imageUrl,
]);
        return redirect()->route('products.index')->with('Succes',$request->product_name.' Has Been Created');
        // return response()->json($product,201); 
    }

public function edit($id)
{
    $product = products::findOrFail($id);
    return view('products.edit', compact('product'));
}
    public function update(product_validate $request , $id)
    {
            $product = products::findOrFail($id);
            $validate =$request->validated();

            if($request->hasFile('image')){
                if($product->image && Storage::disk('public')->exists($product->image)){
                    Storage::disk('public')->delete($product->image);
                }
                $validate['image'] = $request->file('image')->store('photo', 'public');
            }
            $product->update($validate);
            // return response()->json($product,200);
            return redirect()->route('products.index')->with('Succes',$product->product_name.' Has Been Updated');
        }

    public function destroy($id)
    {           
                $product = products::findOrFail($id);
                if($product->image && Storage::disk('public')->exists($product->image)){
                    Storage::disk('public')->delete($product->image);
                }
                products::destroy($id);
                return redirect()->route('products.index')->with('Succes','Product Has Been Deleted');
                // return response()->json(['message'=>'deleted'],200);

    }

        // $products =$id->all();
    public function show(products $id){
        // return View('product.details',compact('product'));
        $product= $id;
        return response()->json($product,200);
        
    }
}
