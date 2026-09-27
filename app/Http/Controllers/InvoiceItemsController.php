<?php

namespace App\Http\Controllers;

use App\Http\Requests\invoice_items_validate;
use App\Models\invoice_items;
use App\Models\invoices;
use App\Models\products;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceItemsController extends Controller
{
        public function store(Request $request){
        $validated_data =$request->validate([
            'items'=>'required|array|min:1',
            'items.*.quantity'=>'required|integer|min:1',
            'items.*.product_id' =>'required|exists:products,id'
        ]);
        try {
            $invoices =DB::transaction(function() use($validated_data){
                $invoice = invoices::create(['total_price' => 0 ,]);

                $grand_total = 0 ;
                foreach($validated_data['items'] as $item){
                    $product = products::findOrFail($item['product_id']);

                    if($product->count < $item['quantity'])
                        {
                            throw new \Exception("Stock not enough for: {$product->product_name}");
                        }

                    $sub_total = $product->price * $item['quantity'];
                    $grand_total += $sub_total ;

                    $product->decrement('count',$item['quantity']);
                    
                    invoice_items::create([
                        'invoice_id'=>$invoice->id,
                        'product_id'=>$product->id,
                        'quantity'=>$item['quantity'],
                        'product_price'=>$product['price'],
                        'total_price' =>$sub_total
                        
                    ]);
                }
                    $invoice->update(['total_price'=>$grand_total]);
                    return $invoice;

                    });
                    // return view('invoices.create')->with('Sucess','Invoice has been created');
                    return redirect()->route('invoices.index')->with('Succes', 'Invoice has been created successfully!');
                    // return response()->json([
                    // 'Message' =>'Succes',
                    // 'data'=> $invoices
                    // ],
                    // 201
                    // );
                    }
                    catch (\Throwable $th) {
                        return redirect()->back()
                        ->withInput()
                        ->with('error', $th->getMessage());
                    // return response()->json([
                    // 'Message' =>$th->getMessage()],
                    // 500
                    // );
                    
                    // return view('invoices.create')->with('Faild',$th->getMessage());
                    }

        }
        public function create()
        {
            $products = products::all();
            return view('invoices.create',compact('products'));
        }
            public function update(invoice_items_validate $request,invoice_items $id)
            {
                $id->update($request->validated());
                // return response()->json($id,200);
            return redirect()->route('invoices_items.index')->with('Succes','New Product Has Been Updated') ;
    }
}
