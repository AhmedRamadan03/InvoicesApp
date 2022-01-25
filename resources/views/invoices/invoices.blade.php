@extends('layouts.master')
@section('css')

    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('title')
    قائمة الفواتير
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between" style="font-family: 'Cairo', sans-serif;">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto" style="font-weight: 900;font-size: 25px">الفواتير</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0" style="font-size: 20px; font-weight: 900;">/ قائمة الفواتير
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('Edit'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تحديث حاله دفع  الفاتوره بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('done'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم استرجاع  الفاتوره بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('Delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتوره بنجاح",
                    type: "success"
                })
            }
        </script>

    @endif
    <div class="row row-sm pb-4 pr-3 text-bold">
        @can('أضافة_فاتوره')
            <a class="model-effect btn btn-outline-primary " href="invoices/create"
                style="font-size: 20px; font-weight: 900;">أضافه فاتورة</a>
        @endcan
        @can('تصدير_EXCel')
            <a class="model-effect btn btn-outline-primary mr-2" href="invoices_export"
                style="font-size: 20px; font-weight: 900;"> تصدير الأكسل</a>
        @endcan

    </div>
    <!-- row -->
    <div class="row" style="font-family: 'Cairo', sans-serif;">

        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">

                </div>
                <div class="card-body text-right">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                            <thead class="">
                                <tr>
                                    <th class="border-bottom-0 pr-2 ">#</th>
                                    <th class="border-bottom-0 pr-2">رقم الفاتورة</th>
                                    <th class="border-bottom-0 pr-2">تاريخ الفاتوره</th>
                                    <th class="border-bottom-0 pr-2">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0 pr-2"> المنتج</th>
                                    <th class="border-bottom-0 pr-2"> القسم</th>
                                    <th class="border-bottom-0 pr-2">الخصم</th>
                                    <th class="border-bottom-0 pr-2">نسبة الضريبة</th>
                                    <th class="border-bottom-0 pr-2">الاجمالي</th>
                                    <th class="border-bottom-0 pr-2">الحالة</th>
                                    <th class="border-bottom-0 pr-2">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($invoices as $invoice)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>
                                            <a href="{{ url('invoiceDetails') }}/{{ $invoice->id }}"
                                                title="عرض الفاتوره">{{ $i }}</a>
                                        </td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_Date }}</td>
                                        <td>{{ $invoice->due_Date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>{{ $invoice->categories->cat_name }}</td>
                                        {{-- <td>{{ $invoice->amount_collection }}</td> --}}
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->value_status == 1)
                                                <span class="text-success">{{ $invoice->status }}</span>
                                            @elseif($invoice->value_status == 2)
                                                <span class="text-danger">{{ $invoice->status }}</span>
                                            @else
                                                <span class="text-warning">{{ $invoice->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary" data-toggle="dropdown"
                                                    id="dropdownMenuButton" type="button" style="padding: 3px !important;">
                                                    العمليات
                                                    <i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    @can('تعديل_الفاتوره')
                                                        <a class="dropdown-item"
                                                            href="{{ url('edit_invoice') }}/{{ $invoice->id }}">تعديل</a>
                                                    @endcan
                                                    @can('حذف_الفاتورة')
                                                        <a class="dropdown-item" data-target="#delete_invoice"
                                                            data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                            href="#modaldemo9" title="حذف"> حذف </a>
                                                    @endcan
                                                    @can('تغيير_حاله_الدفع')
                                                        <a class="dropdown-item "
                                                            href="{{ URL::route('status.show', [$invoice->id]) }}"
                                                            title="تغيير حاله الدفع"> <i class="text-success fas fa-exchange-alt"></i> تغيير
                                                            حاله الدفع </a>
                                                    @endcan
                                                    @can('ارشفه_الفواتير')
                                                        <a class="dropdown-item " data-target="#Archive_invoice"
                                                            data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                            href="#modaldemo9" title="ارشفه"> أرشفة </a>
                                                    @endcan

                                                    <a class="dropdown-item "
                                                        href="{{ url('print_invoice') }}/{{ $invoice->id }}"> <i
                                                            class="text-success fas fa-print"></i> طباعه الفاتوره </a>

                                                </div>

                                            </div>

                                        </td>


                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- حدف الفاتوره --}}
            <div class="modal fade" id="delete_invoice">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">حذف الفاتوره</h6><button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('invoice.destroy') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <p>هل انت متاكد من حذف هذه الفاتوره ؟</p><br>
                                <input type="hidden" name="id" id="id" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>

            {{-- ارشفه فاتوره --}}
            <div class="modal fade" id="Archive_invoice">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">ارشفة الفاتوره</h6><button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('invoice.destroy') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <p>هل انت متاكد من ارشفة هذه الفاتوره ؟</p><br>
                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="id_page" id="id_page" value="2">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-success">تاكيد</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')

    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#Archive_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>
    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>
@endsection
