<?php

namespace App\Http\Controllers;

use App\Http\Requests\invoice_items_validate;
use App\Models\invoice_items;
use App\Models\invoices;
use App\Models\InvoiceItemsController;
use App\Models\products;
use GuzzleHttp\Psr7\Message;
// use Illuminate\Container\Attributes\DB;
// use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class InvoicesController extends Controller
{
    public function index()
    {   

        $items = invoices::all();
        $totals = invoice_items::select('invoice_id', DB::raw('SUM(quantity) as total_items'))
    ->groupBy('invoice_id')
    ->get();
        return view('invoices.index',compact('items','totals'));
        }
        
        // $count =DB::table('invoice_items')->join('invoice_items','invoice_items.invoice_id'.'='.'invoices.id')->select('quantity')->get();
        // return response()->json($items,200);
        
        public function destroy($id)
        {
            invoices::destroy($id);
            return redirect()->route('invoices.index')->with('Succes','New Product Has Been Deleted') ;
            // return response()->json('message:deleted',200);
            
            }
public function show($id)
{
    $invoice = invoices::findOrFail($id);

    $items =DB::table('invoice_items')
        ->join('products','invoice_items.product_id', '=', 'products.id')->
        where('invoice_items.invoice_id', $id)->
        select(
        'products.product_name',
        'invoice_items.product_id',
        'invoice_items.quantity',
        'invoice_items.product_price',
        'invoice_items.total_price'
        )->get();
    
return view('invoices.show', compact('invoice', 'items'));
   // return response()->json([
    //     'invoice_id' => $id,
    //     'items'      => $data
    // ], 200);
}
}
