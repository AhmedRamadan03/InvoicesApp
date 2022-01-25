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
    الأقسام
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between"
        style="font-family: 'Cairo', sans-serif; font-size: 20px; font-weight: 700;">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto" style="font-weight: 900;font-size: 25px">الأعدادات</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0" style="font-size: 20px; font-weight: 900;"> / الأقسام</span>
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
                msg: "تم أضافه القسم بنجاح",
                type: "success"
            })
        }
    </script>
    @endif
    @if (session()->has('Edit'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم تعديل القسم بنجاح",
                type: "success"
            })
        }
    </script>
    @endif
    @if (session()->has('Delete'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم حذف القسم بنجاح",
                type: "success"
            })
        }
    </script>
    @endif

  @can('أضافة_قسم')
  <div class="row row-sm pb-4 pr-3 text-bold">
    <a class="model-effect btn btn-outline-primary " data-effect="effect-scale" data-target="#modaldemo8"
        data-toggle="modal" href="" style="font-size: 20px; font-weight: 900;">أضافه قسم</a>
</div>
  @endcan
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                {{-- <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mg-b-0">Bordered Table</h4>
                                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                                </div>
                                <p class="tx-12 tx-gray-500 mb-2">Example of Valex Bordered Table.. <a href="">Learn more</a></p>
                            </div> --}}
                <div class="card-body ">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                            <thead class="">
                                <tr>
                                    <th class="border-bottom-0 pr-2 ">#</th>
                                    <th class="border-bottom-0 pr-2">اسم القسم</th>
                                    <th class="border-bottom-0 pr-2">الوصف</th>
                                    <th class="border-bottom-0 pr-2">المستخدم</th>
                                    <th class="border-bottom-0 pr-2">العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $cat)
                                    <tr>
                                        <td>{{ $cat->id }}</td>
                                        <td>{{ $cat->cat_name }}</td>
                                        <td>{{ $cat->description }}</td>
                                        <td>{{ $cat->created_by }}</td>
                                        <td>

                                           @can('تعديل_قسم')
                                           <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                           data-id="{{ $cat->id }}" data-cat_name="{{ $cat->cat_name }}"
                                           data-description="{{ $cat->description }}" data-toggle="modal"
                                           href="#exampleModal2" title="تعديل"> تعديل <i
                                               class="las la-pen"></i></a>
                                           @endcan

                                          @can('حذف_قسم')
                                          <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                          data-id="{{ $cat->id }}" data-cat_name="{{ $cat->cat_name }}"
                                          data-toggle="modal" href="#modaldemo9" title="حذف"> حذف <i
                                              class="las la-trash"></i></a>

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
        <!--  أضافه قسم -->
        <div class="modal fade" id="modaldemo8" style="font-family: 'Cairo', sans-serif;">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">أضافه قسم</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <lable for="exampleInputEmail" style="font-size: 20px; font-weight: 900;">أسم القسم</lable>
                                <input type="text" class="form-control " id="cat_name" name="cat_name" required>
                            </div>
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
        <!-- End Basic modal -->
        {{-- تعديل القسم --}}
        <div class="modal fade" id="exampleModal2">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل القسم</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('cat.update') }}" method="post" autocomplete="off">

                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" value="">
                                <lable for="exampleInputEmail" style="font-size: 20px; font-weight: 900;">أسم القسم</lable>
                                <input type="text" class="form-control " id="cat_name" name="cat_name" value="" required>
                            </div>
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

        {{-- حدف قسم --}}
        <div class="modal fade" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('cat.destroy') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <p>هل انت متاكد من حذف هذا القسم ؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
                            <input class="form-control" name="cat_name" id="cat_name" type="text" readonly>
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

    {{-- script jquery to show data from table in form --}}
    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var cat_name = button.data('cat_name')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #cat_name').val(cat_name);
            modal.find('.modal-body #description').val(description);
        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var cat_name = button.data('cat_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #cat_name').val(cat_name);
        })
    </script>
@endsection
