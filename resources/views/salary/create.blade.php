@extends('layouts.default')

@section('title') Thêm lương @endsection

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Thêm lương</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('salaries.index') }}" title="Quản lý lương" data-toggle="tooltip" data-placement="top">Quản lý lương</a></li>
                                    <li class="breadcrumb-item active">Thêm lương</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <form class="repeater custom-validation" method="POST" action="{{ route('salaries.store') }}" enctype="multipart/form-data">
                            @include('salary._form')
                        </form>

                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Skote.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-right d-none d-sm-block">
                            Design & Develop by Themesbrand
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection

@push('js')
    <!-- select 2 plugin -->
    <script src="{{ asset('libs\select2\js\select2.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ asset('js\pages\ecommerce-select2.init.js') }}"></script>

    <!-- datepicker -->
    <script src="{{ asset('libs\bootstrap-datepicker\js\bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('libs\bootstrap-colorpicker\js\bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('libs\bootstrap-timepicker\js\bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('libs\bootstrap-touchspin\jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('libs\bootstrap-maxlength\bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('libs\@chenfengyuan\datepicker\datepicker.min.js') }}"></script>
    <!-- form advanced init -->
    <script src="{{ asset('js\pages\form-advanced.init.js') }}"></script>

    <!-- form repeater js -->
    <script src="{{ asset('libs\jquery.repeater\jquery.repeater.min.js') }}"></script>

    <script src="{{ asset('js\pages\form-repeater.int.js') }}"></script>

    <script src="{{ asset('libs\parsleyjs\parsley.min.js') }}"></script>

    <script src="{{ asset('js\pages\form-validation.init.js') }}"></script>

    <script type="text/javascript">
        $('#month').datepicker({
            format: 'mm',
        });

        $('#year').datepicker({
            format: 'yyyy',
        });

        function getInsuranceCard(id) {
            if (id){
                $.ajax({
                    url: "/health_insurance_cards/"+id+"/get-insurance-card",
                    type: "POST",
                    success: function (respon) {
                        if (respon) {
                            $(`#check_insurance_card`).prop('checked', true);
                            $(`#is_health_insurance_card`).prop('checked', true);
                            $(`#total_money`).val(0).prop('readonly', true);
                        }
                        else {
                            $(`#check_insurance_card`).prop('checked', false);
                            $(`#is_health_insurance_card`).prop('checked', false);
                            $(`#total_money`).prop('readonly', false);
                        }
                    },
                    errors: function () {
                        alert('Lỗi server!!!');
                    }
                });
            }
            else {
                $(`#check_insurance_card`).prop('checked', false);
                $(`#is_health_insurance_card`).prop('checked', false);
                $(`#total_money`).prop('readonly', false);
            }
        }
    </script>
@endpush

@push('css')
    <!-- datepicker css -->
    <link href="{{ asset('libs\bootstrap-datepicker\css\bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs\bootstrap-colorpicker\css\bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs\bootstrap-timepicker\css\bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('libs\@chenfengyuan\datepicker\datepicker.min.css') }}">
    <!-- select2 css -->
    <link href="{{ asset('libs\select2\css\select2.min.css') }}" rel="stylesheet" type="text/css">

    <style type="text/css">
        .custom-validate-select .filled{
            position: absolute;
            top: 65px;
        }
    </style>
@endpush