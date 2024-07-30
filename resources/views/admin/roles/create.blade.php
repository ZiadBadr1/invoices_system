@extends('layouts.master')
@section('title', 'اضافة الصلاحيات')
@section('open-users','open')
@section('active-roles','active')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة نوع مستخدم</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
{{--           @dd($errors)--}}
            @include('partials.alert')
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.index') }}">رجوع</a>
                            </div>
                        </div>
                        <br>
                        <div class="main-content-label mg-b-5">
                            <div class="col-xs-7 col-sm-7 col-md-7">
                                <div class="form-group">
                                    <p>اسم الصلاحية:</p>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <ul id="treeview1">
                                    <li><a href="#">الصلاحيات</a>
                                        <ul>
                                            @foreach($permission as $value)
                                                <li>
                                                    <label style="font-size: 16px;">
                                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}">
                                                        {{ $value->name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-main-primary">تأكيد</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection
