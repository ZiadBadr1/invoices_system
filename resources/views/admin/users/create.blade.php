@extends('layouts.master')
@section('title', 'إضافة مستخدم جديد')
@section('open-users','open')
@section('active-users','active')

@section('css')
    <link href="{{ asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة مستخدم</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            @include('partials.alert')

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.users.index') }}">رجوع</a>
                        </div>
                    </div>
                    <br>
                    <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                          action="{{ route('admin.users.store', 'test') }}" method="post">
                        @csrf

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6">
                                <label>اسم المستخدم: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20 @error('name') is-invalid @enderror"
                                       name="name" type="text" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20 @error('email') is-invalid @enderror"
                                       name="email" type="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                <label>كلمة المرور: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20 @error('password') is-invalid @enderror"
                                       name="password" type="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                <label>تأكيد كلمة المرور: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20 @error('password_confirmation') is-invalid @enderror"
                                       name="password_confirmation" type="password">
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mg-b-20">
                            <div class="col-lg-6">
                                <label class="form-label">حالة المستخدم</label>
                                <select name="status" class="form-control nice-select custom-select @error('status') is-invalid @enderror">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>مفعل</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>غير مفعل</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mg-b-20">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">صلاحية المستخدم</label>
                                    <select name="roles_name[]" class="form-control @error('roles_name') is-invalid @enderror" multiple>
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}" {{ (collect(old('roles_name'))->contains($role)) ? 'selected' : '' }}>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-main-primary pd-x-20" type="submit">تأكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
    <!-- Internal Nice-select js-->
    <script src="{{ asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>

    <!-- Internal Parsley.min js -->
    <script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <!-- Internal Form-validation js -->
@endsection
