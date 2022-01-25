<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\invoices;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index(){

        $categories = categories::all();
        return view('reports.customer_report',compact('categories'));
          
      }
  
  
      public function Search_customers(Request $request){
  
  
  // في حالة البحث بدون التاريخ
        
       if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {
  
         
        $invoices = invoices::select('*')->where('cat_id','=',$request->Section)->where('product','=',$request->product)->get();
        $categories = categories::all();
         return view('reports.customer_report',compact('categories'))->withDetails($invoices);
  
      
       }
  
  
    // في حالة البحث بتاريخ
       
       else {
         
         $start_at = date($request->start_at);
         $end_at = date($request->end_at);
  
        $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('cat_id','=',$request->Section)->where('product','=',$request->product)->get();
         $categories = categories::all();
         return view('reports.customer_report',compact('categories'))->withDetails($invoices);
  
        
       }
       
    
      
      }
}
