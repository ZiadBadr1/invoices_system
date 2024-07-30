@extends('layouts.master')
@section('title', 'تعديل المستخدم')

@section('open-users','open')
@section('active-users','active')

@section('css')
    <link href="{{ asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل مستخدم</span>
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
                    </div><br>

                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PATCH')

                        <div class="row mg-b-20">
                            <div class="col-md-6">
                                <label>اسم المستخدم: <span class="tx-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mg-t-20 mg-md-t-0">
                                <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mg-b-20">
                            <div class="col-md-6 mg-t-20 mg-md-t-0">
                                <label>كلمة المرور:</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mg-t-20 mg-md-t-0">
                                <label>تأكيد كلمة المرور:</label>
                                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
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
                                    <option value="">أختر حالة المستخدم</option>
                                    <option value="1" @selected($user->status == 1)>مفعل</option>
                                    <option value="0" @selected($user->status == 0)>غير مفعل</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mg-b-20">
                            <div class="col-12">
                                <label>نوع المستخدم:</label>
                                <select name="roles_name[]" class="form-control @error('roles_name') is-invalid @enderror" multiple>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ in_array($role, $userRole) ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('roles_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mg-t-30">
                            <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
    <script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{ asset('assets/js/form-validation.js')}}"></script>
@endsection
