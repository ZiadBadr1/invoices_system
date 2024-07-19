@extends('layouts.master')
@section('title','تغير حالة الدفع')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تغير حالة الدفع</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.invoices.update-status', $invoice) }}" method="post" autocomplete="off">
                        @csrf
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number" disabled
                                       title="يرجي ادخال رقم الفاتورة" value="{{ old('invoice_number', $invoice->invoice_number) }}">
                                @error('invoice_number')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD" type="text" disabled
                                       value="{{ old('invoice_date', $invoice->invoice_date) }}">
                                @error('invoice_date')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD" type="text" disabled
                                       value="{{ old('due_date', $invoice->due_date) }}">
                                @error('due_date')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="section_id" class="form-control " disabled>
                                    <option value="{{ $invoice->section_id }}" selected>
                                        {{ $invoice->section->name }}
                                    </option>
                                </select>
                                @error('section_id')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select id="product" name="product_id" class="form-control" disabled>
                                    <option value="{{ $invoice->product_id }}" selected>
                                        {{ $invoice->product->name }}
                                    </option>
                                </select>
                                @error('product_id')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="inputName" name="amount_collection" disabled
                                       value="{{ old('amount_collection', $invoice->amount_collection) }}"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                @error('amount_collection')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- 3 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="amount_commission" name="amount_commission" disabled
                                       title="يرجي ادخال مبلغ العمولة "
                                       value="{{ old('amount_commission', $invoice->amount_commission) }}"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                @error('amount_commission')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount" disabled
                                       title="يرجي ادخال مبلغ الخصم "
                                       value="{{ old('discount', $invoice->discount) }}"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                @error('discount')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_VAT" id="rate_VAT" class="form-control" onchange="myFunction()" disabled>
                                    <option value="" selected disabled>حدد نسبة الضريبة</option>
                                    <option value="5%" {{ old('rate_VAT', $invoice->rate_VAT) == '5%' ? 'selected' : '' }}>5%</option>
                                    <option value="10%" {{ old('rate_VAT', $invoice->rate_VAT) == '10%' ? 'selected' : '' }}>10%</option>
                                </select>
                                @error('rate_VAT')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- 4 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="value_VAT" name="value_VAT" readonly disabled
                                       value="{{ old('value_VAT', $invoice->value_VAT) }}">
                                @error('value_VAT')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="total" name="total" readonly disabled
                                       value="{{ old('total', $invoice->total) }}">
                                @error('total')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3" disabled>{{ old('note', $invoice->note) }}</textarea>
                            </div>
                            @error('note')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><br>
                        @php
                            use App\Enums\InvoiceStatus;
                        @endphp

                        <div class="row">
                            <div class="col">
                                <label for="Status">حالة الدفع</label>
                                <select class="form-control" id="status" name="status"  >
                                    <option selected="true" disabled="disabled">-- حدد حالة الدفع --</option>
                                    @foreach (InvoiceStatus::cases() as $status)
                                        @if($status->value != 0 )
                                        <option value="{{ $status->value }}" >
                                            {{ InvoiceStatus::getDescription($status) }}
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('status')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                            <div class="col">
                                <label>تاريخ الدفع</label>
                                <input class="form-control fc-datepicker" name="payment_date" placeholder="YYYY-MM-DD"
                                       type="text"  >
                                @error('payment_date')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">تحديث حالة الدفع</button>
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
    <!-- Internal Select2 js-->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>
@endsection