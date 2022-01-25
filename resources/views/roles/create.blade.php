@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/morris.js/morris.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    أضافه صلاحية
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ أضافة
                    صلاحية</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">

            <div class="pull-right">
                <a class="btn btn-outline-primary mb-2" href="{{ route('roles.index') }}"> رجوع </a>
            </div>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header tx-medium bd-0 tx-white bg-secondary">
                أضافة صلاحية جديدة
                </div>
                <div class="card-body ">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>الأسم:</strong>
                                {!! Form::text('name', null, ['placeholder' => 'الأسم ', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>الصلاحيات:</strong>
                                <br />
                                @foreach ($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                                        {{ $value->name }}</label>
                                    <br />
                                @endforeach
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
