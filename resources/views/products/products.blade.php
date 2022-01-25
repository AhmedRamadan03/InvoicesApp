@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

@endsection
@section('title')
    المنتجات
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('Add'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم أضافه المنتج بنجاح",
                type: "success"
            })
        }
    </script>
    @endif
    @if (session()->has('Edit'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم تعديل المنتج بنجاح",
                type: "success"
            })
        }
    </script>
    @endif
    @if (session()->has('Delete'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم حذف المنتج بنجاح",
                type: "success"
            })
        }
    </script>
    @endif
    <div class="row row-sm pb-4 pr-3 text-bold">
       @can('أضافه_منتج')
       <a class="model-effect btn btn-outline-primary " data-effect="effect-scale" data-target="#modaldemo8"
       data-toggle="modal" href="" style="font-size: 20px; font-weight: 900;">أضافه منتج</a>
       @endcan
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">

                </div>
                <div class="card-body text-right">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                            <thead class="">
                                <tr>
                                    <th class="border-bottom-0 pr-2">#</th>
                                    <th class="border-bottom-0 pr-2"> المنتج</th>
                                    <th class="border-bottom-0 pr-2"> القسم</th>
                                    <th class="border-bottom-0 pr-2"> ملاحظات</th>
                                    <th class="border-bottom-0 pr-2"> العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $prod)
                                    <tr>
                                        <td>{{ $prod->id }}</td>
                                        <td>{{ $prod->product_name }}</td>
                                        <td>{{ $prod->categories->cat_name }}</td>
                                        <td>{{ $prod->description }}</td>
                                        <td>
                                           @can('تعديل_منتج')
                                           <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                           data-id="{{ $prod->id }}"
                                           data-product_name="{{ $prod->product_name }}"
                                           data-cat_name="{{ $prod->categories->cat_name }}"
                                           data-description="{{ $prod->description }}" data-toggle="modal"
                                           href="#exampleModal2" title="تعديل"> تعديل <i
                                               class="las la-pen"></i></a>
                                           @endcan
                                           @can('جذف_منتج')
                                           <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                           data-id="{{ $prod->id }}"
                                           data-product_name="{{ $prod->product_name }}" data-toggle="modal"
                                           href="#modaldemo9" title="حذف"> حذف <i class="las la-trash"></i></a>
                                           @endcan

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--  أضافه منتج -->
        <div class="modal fade" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">أضافه منتج</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('product.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <lable for="exampleInputEmail" style="font-size: 20px; font-weight: 900;">أسم النتج</lable>
                                <input type="text" class="form-control " id="product_name" name="product_name" required>
                            </div>
                            <lable for="exampleInputEmail" style="font-size: 20px; font-weight: 900;"> القسم</lable>
                            <select name="cat_id" id="cat_id" class="form-control" required>
                                <option value="" selected disabled class="form-control">--حدد القسم--</option>
                                @foreach ($cats as $cat)
                                    <option class="form-control" value="{{ $cat->id }}">{{ $cat->cat_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-group">
                                <lable for="exampleInputEmail" style="font-size: 20px; font-weight: 900;"> ملاحظات </lable>
                                <textarea type="text" class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn  btn-primary" type="submit">تأكيد</button>
                            <button class="btn  btn-secondary" data-dismiss="modal" type="button">أغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- تعديل المنتج --}}
        <div class="modal fade" id="exampleModal2">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل المنتج</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('product.update') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" value="">
                                <lable for="exampleInputEmail" style="font-size: 20px; font-weight: 900;">أسم المنتج</lable>
                                <input type="text" class="form-control " id="product_name" name="product_name" value=""
                                    required>
                            </div>
                            <lable for="exampleInputEmail" style="font-size: 20px; font-weight: 900;"> القسم</lable>
                            <select name="cat_name" id="cat_name" class="form-control">
                                @foreach ($cats as $cat)
                                    <option class="form-control">
                                        {{ $cat->cat_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-group">
                                <lable for="exampleInputEmail" style="font-size: 20px; font-weight: 900;"> ملاحظات </lable>
                                <textarea type="text" class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn  btn-primary" type="submit">تأكيد</button>
                            <button class="btn  btn-secondary" data-dismiss="modal" type="button">أغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- حدف منتج --}}
        <div class="modal fade" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('product.destroy') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <p>هل انت متاكد من حذف هذا المنتج ؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
                            <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
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
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var product_name = button.data('product_name')
            var cat_name = button.data('cat_name')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #cat_name').val(cat_name);
            modal.find('.modal-body #description').val(description);
        })
    </script>
    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var product_name = button.data('product_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
        })
    </script>
@endsection
