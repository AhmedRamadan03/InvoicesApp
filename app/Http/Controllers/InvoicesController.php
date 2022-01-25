<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\categories;
use App\Models\invoices;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\invoic_attachments;
use App\Models\User;
use App\Notifications\Add_Invoice;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{
    /**
     * Display a litings of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:قائمة_الفواتير|', ['only' => ['index','store']]);
    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
        $file     = invoic_attachments::all();
        return view('invoices.invoices', compact('invoices', 'file'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = categories::all();
        return view('invoices.create_invoice', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'invoice_number' => 'required|unique:invoices|max:255',
        //     'invoice_Date' => 'required',
        //     'due_Date' => 'required',
        //     'product' => 'required',
        //     'cat_id' => 'required',
        //     'amount_collection' => 'required',
        //     'amount_Commission' => 'required',
        //     'discount' => 'required',
        //     'rate_vat' => 'required'
        // ], [
        //     'invoice_number.required'       => 'رقم الفاتوره موجود مسبقا',
        //     'invoice_Date.required'  => 'يرجي ادخال تاريخ الفاتوره ',
        //     'due_Date.required'  => 'يرجي ادخال تاريخ استحقاق الفاتوره ',
        //     'product.required'  => 'يرجي اختيار  المنتج ',
        //     'cat_id.required'  => 'يرجي  اختيار القسم ',
        //     'amount_collection.required'  => 'يرجي ادخال مبلغ التحصيل  ',
        //     'amount_Commission.required'  => 'يرجي ادخال مبلغ العموله  ',
        //     'discount.required'  => 'يرجي ادخال خصم الفاتوره ',
        //     'rate_vat.required'  => 'يرجي ادخال نسبه الضاريبه علي الفاتوره '
        // ]);

        invoices::insert([
            'invoice_number'      => $request->invoice_number,
            'invoice_Date'        => $request->invoice_Date,
            'due_Date'            => $request->Due_date,
            'product'             => $request->product,
            'cat_id'              => $request->cateogry,
            'amount_collection'   => $request->Amount_collection,
            'amount_Commission'   => $request->Amount_Commission,
            'discount'            => $request->Discount,
            'rate_vat'            => $request->Rate_VAT,
            'value_vat'           => $request->Value_VAT,
            'total'               => $request->Total,
            'note'                => $request->note,
            'status'              => 'غير مدفوعه',
            'value_status'        => '2',
            'user'                => (Auth::user()->name),
        ]);
        $invoice_id = invoices::orderByDesc('id')->latest()->first()->id;
        invoices_details::insert([
            'invoice_id'        => $invoice_id,
            'invoice_number'    => $request->invoice_number,
            'product'           => $request->product,
            'category'          => $request->cateogry,
            'status'            => 'غير مدفوعه',
            'value_status'      => '2',
            'nots'              => $request->note,
            'user'              => (Auth::user()->name),
        ]);
        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::orderByDesc('id')->latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoic_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        // $user = User::get();
        // $invoices = invoices::latest()->first();
        // Notification::send($user, new Add_Invoice($invoices));
    
        session()->flash('Add', __("msg.invoice_add_successfull", [], "ar"));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = invoices::where('id', $id)->first();
        return view('invoices.status_show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = invoices::where('id', $id)->first();
        $cats = categories::all();
        return view('invoices.edit_invoice', compact('invoice', 'cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoice = invoices::find($request->invoice_id);
        $invoice->update([
            'invoice_number'      => $request->invoice_number,
            'invoice_Date'        => $request->invoice_Date,
            'due_Date'            => $request->Due_date,
            'product'             => $request->product,
            'cat_id'              => $request->cateogry,
            'amount_collection'   => $request->Amount_collection,
            'amount_Commission'   => $request->Amount_Commission,
            'discount'            => $request->Discount,
            'rate_vat'            => $request->Rate_VAT,
            'value_vat'           => $request->Value_VAT,
            'total'               => $request->Total,
            'note'               => $request->note,
        ]);

        session()->flash('Edit');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $details = invoic_attachments::where('invoice_id', $id)->first();
        $invoice = invoices::where('id',$id)->first();
        $id_page = $request->id_page;

        if(!$id_page == 2){
            if (!empty($details->invoice_id)) {
                Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
            }
            $invoice->forcedelete();
            session()->flash('Delete', __("msg.invoice_delete_successfull", [], "ar"));
            return redirect('/invoices');
        } 
        else{
            $invoice->Delete();
            session()->flash('Archives', __("msg.invoice_delete_successfull", [], "ar"));
            return redirect('/invoices_archives');
        }
        
       
    }


    public function getProducts($id)
    {
        return DB::table('products')->where('cat_id', $id)->pluck('product_name', 'id');
    }

    public function statusUpdate(Request $request, $id)
    {
        $invoice = invoices::where('id',$id)->first();
        if( $request->status === 'مدفوعه'){
            $invoice->update([
                'payment_date'=>$request->payment_date,
                'value_status' => 1,
                'status'=>$request->status
            ]);
            invoices_details::insert([
                'invoice_id'          =>$request->invoice_id,
                'invoice_number'      => $request->invoice_number,
                'product'             => $request->product,
                'category'              => $request->cateogry,
                'status'              =>$request->status,
                'value_status'        => 1,
                'nots'                => $request->note,
                'payment_date'        =>$request->payment_date,
                'user'              => (Auth::user()->name),

            ]);
        } else{
            $invoice->update([
                'payment_date'=>$request->payment_date,
                'value_status' => 3,
                'status'=>$request->status
            ]);
            invoices_details::insert([
                'invoice_id'          =>$request->invoice_id,
                'invoice_number'      => $request->invoice_number,
                'product'             => $request->product,
                'category'              => $request->cateogry,
                'status'              =>$request->status,
                'value_status'        => 1,
                'nots'                => $request->note,
                'payment_date'        =>$request->payment_date,
                'user'              => (Auth::user()->name),

            ]);
        }
        session()->flash('Edit');
        return redirect('/invoices');
    }

    public function invoicePaid()
    {
        $invoices = invoices::where('value_status',1)->get();
        return view('invoices.invoices_paid',compact('invoices'));   
    }

    public function invoiceUnpaid(){
        $invoices = invoices::where('value_status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }
    public function invoicePartial()
    {
        $invoices = invoices::where('value_status',3)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }

    public function printInvoice(Request $request){
        $invoice = invoices::where('id',$request->id)->first();
        
        return view('invoices.invoice',compact('invoice'));
    }

   // to export invoices to excel
   public function export() 
   {
       
       return Excel::download(new InvoicesExport, 'الفواتير.xlsx');
   }
}
