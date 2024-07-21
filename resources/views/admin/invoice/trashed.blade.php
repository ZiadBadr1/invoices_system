@extends('layouts.master')
@section('title','أرشيف الفواتير')
@section('open-invoices', 'open')
@section('active-trashed-invoices', 'active')

@section('css')
    {{--    /*<!-- Internal Data table css -->*/--}}
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    {{--    <!--Internal   Notify -->--}}
    <link href="{{ asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ أرشيف
                    الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @include('partials.alert')

    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ القاتورة</th>
                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">نسبة الضريبة</th>
                                <th class="border-bottom-0">قيمة الضريبة</th>
                                <th class="border-bottom-0">الاجمالي</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invoices as $key => $invoice)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $invoice->invoice_number }} </td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ $invoice->due_date }}</td>
                                    <td>{{ $invoice->product->name }}</td>

                                    <td>
                                        <a
                                                href="{{route('admin.invoices.show',$invoice)}}">{{ $invoice->section->name }}
                                        </a>
                                    </td>
                                    <td>{{ $invoice->discount }}</td>
                                    <td>{{ $invoice->rate_VAT }}</td>
                                    <td>{{ $invoice->value_VAT }}</td>
                                    <td>{{ $invoice->total }}</td>
                                    @php
                                        $status = \App\Enums\InvoiceStatus::from($invoice->status);
                                        $color = \App\Enums\InvoiceStatus::getColor($status);
                                        $description = \App\Enums\InvoiceStatus::getDescription($status);
                                    @endphp

                                    <td style="color: {{ $color }}">
                                        {{ $description }}
                                    </td>

                                    <td>{{ $invoice->note }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i>
                                            </button>
                                            <div class="dropdown-menu tx-13">
                                                {{--                                                @can('ارشفة الفاتورة')--}}
                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                   data-toggle="modal" data-target="#Transfer_invoice">
                                                    <i class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                    الفواتير
                                                </a>

                                                {{--                                                @endcan--}}
                                                {{--                                                @can('حذف الفاتورة')--}}
                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                   data-toggle="modal" data-target="#delete_invoice"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                    الفاتورة</a>


                                                {{----}}
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
        </div>
        <!--/div-->
    </div>


    <!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm" method="post">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        هل انت متاكد من عملية الحذف ؟
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- إلغاء أرشفة الفاتورة -->
    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إلغاء أرشفة الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="restoreForm" method="post">
                    @csrf
                    <div class="modal-body">
                        هل انت متأكد من إلغاء عملية ألأرشفة ؟
                        <input type="hidden" name="invoice_id" id="restore_invoice_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-success">تأكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle the delete modal
            $('#delete_invoice').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var invoiceId = button.data('invoice_id');
                var formAction = "{{ route('admin.trashed-invoices.force-delete', ':id') }}";
                formAction = formAction.replace(':id', invoiceId);

                var modal = $(this);
                modal.find('#deleteForm').attr('action', formAction);
                modal.find('.modal-body #invoice_id').val(invoiceId);
            });

            // Handle the restore modal
            $('#Transfer_invoice').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var invoiceId = button.data('invoice_id');
                var formAction = "{{ route('admin.invoices.restore', ':id') }}";
                formAction = formAction.replace(':id', invoiceId);

                var modal = $(this);
                modal.find('#restoreForm').attr('action', formAction);
                modal.find('.modal-body #restore_invoice_id').val(invoiceId);
            });
        });

    </script>

@endsection