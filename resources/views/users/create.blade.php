@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/morris.js/morris.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    أضافه مستخدم
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ أضافة
                    مستخدم</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">

            <div class="pull-right">
                <a class="btn btn-outline-primary mb-2" href="{{ route('users.index') }}"> رجوع </a>
            </div>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header tx-medium bd-0 tx-white bg-secondary">
                    أضافة مستخدم
                </div>
                <div class="card-body ">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>خطأ!</strong> توجد بعض الأخطاء في عمليه الادخال.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>الأسم :</strong>
                                {!! Form::text('name', null, ['placeholder' => 'اسم المستخدم', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>البريد الألكتروني:</strong>
                                {!! Form::text('email', null, ['placeholder' => 'البريد الألكتروني', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>كلمة المرور:</strong>
                                {!! Form::password('password', ['placeholder' => ' كلمة المرور', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong> تأكيد كلمة المرور:</strong>
                                {!! Form::password('confirm-password', ['placeholder' => ' تأكيد كلمة المرور', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <label class="form-label">حالة المستخدم</label>
                            <select name="status" id="select-beast" class="form-control  nice-select  custom-select">
                                <option value="مفعل">مفعل</option>
                                <option value="غير مفعل">غير مفعل</option>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>الصلاحيات:</strong>
                                {!! Form::select('roles_name[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
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
@endsection
