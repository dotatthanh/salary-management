@extends('layouts.default')

@section('title') Quản lý lương @endsection

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Danh sách lương</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);" title="Quản lý" data-toggle="tooltip" data-placement="top">Quản lý</a></li>
                                    <li class="breadcrumb-item active">Danh sách lương</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('salaries.index') }}">
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <div class="search-box mr-2 mb-2 d-inline-block">
                                                <div class="position-relative">
                                                    <input type="text" name="name" class="form-control" placeholder="Nhập tên nhân viên" value="{{ $request->name }}">
                                                    <i class="bx bx-search-alt search-icon"></i>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-3">
                                            <div class="docs-datepicker">
                                                <div class="input-group">
                                                    <input type="text" class="form-control docs-date" id="month" name="month" placeholder="Chọn tháng" autocomplete="off" value="{{ $request->month }}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger" disabled="">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="docs-datepicker-container"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="docs-datepicker">
                                                <div class="input-group">
                                                    <input type="text" class="form-control docs-date" id="year" name="year" placeholder="Chọn năm" autocomplete="off" value="{{ $request->year }}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger" disabled="">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="docs-datepicker-container"></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                                <i class="bx bx-search-alt search-icon font-size-16 align-middle mr-2"></i> Tìm kiếm
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="row">
                                    <div class="col-sm-6">
                                        @can('Nhập lương excel')
                                            <form action="{{ route('salaries.import-excel') }}" method="POST" enctype="multipart/form-data">
                                                @csrf

                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="file" required="" class="custom-file-input" id="inputGroupFile04">
                                                        <label class="custom-file-label" for="inputGroupFile04">Chọn file Excel</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-outline-success">Nhập lương Excel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endcan
                                    </div>

                                    <div class="col-sm-3">
                                        @can('Lấy file mẫu')
                                            <a href="{{ route('salaries.export-excel') }}" target="_blank" class="text-white btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i>Lấy file mẫu</a>
                                        @endcan
                                    </div>

                                    @can('Thêm lương')
                                    <div class="col-sm-3">
                                        <div class="text-sm-right">
                                            <a href="{{ route('salaries.create') }}" class="text-white btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i> Thêm lương</a>
                                        </div>
                                    </div>
                                    @endcan
                                </div>

                                {{-- render error import excel --}}
                                @if (session()->has('failures'))
                                    <table class="table table-danger">
                                        <tr>
                                            <th colspan="2" class="text-center font-weight-bold">Có một số lỗi xảy ra</th>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Hàng</td>
                                            <td class="font-weight-bold">Lỗi</td>
                                        </tr>
                                        @foreach(session()->get('failures') as $validation)
                                        <tr>
                                            <td>{{ $validation->row() }}</td>
                                            <td>
                                                <ul>
                                                    @foreach($validation->errors() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                @endif
                                </div>




                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 70px;" class="text-center">STT</th>
                                                <th>Tên nhân viên</th>
                                                <th>Kỳ</th>
                                                <th>Tổng số ngày làm việc</th>
                                                <th>Ngày nghỉ phép</th>
                                                <th>Ngày nghỉ không phép</th>
                                                <th>Tổng số ngày nghỉ</th>
                                                <th>Tổng tiền lương</th>
                                                <th class="text-center">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php ($stt = 1)
                                            @foreach ($salaries as $salary)
                                                <tr>
                                                    <td class="text-center">{{ $stt++ }}</td>
                                                    <td>{{ $salary->user->name }}</td>
                                                    <td>{{ $salary->month }}/{{ $salary->year }}</td>
                                                    <td>{{ $salary->total_working_days }} ngày</td>
                                                    <td>{{ $salary->paid_day_off }} ngày</td>
                                                    <td>{{ $salary->unpaid_day_off }} ngày</td>
                                                    <td>{{ $salary->total_days_off }} ngày</td>
                                                    <td>{{ number_format($salary->salary, 0, ',', '.') }} VND</td>
                                                    <td class="text-center">
                                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                                            @can('Chỉnh sửa lương')
                                                            <li class="list-inline-item px">
                                                                <a href="{{ route('salaries.edit', $salary->id) }}" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="mdi mdi-pencil text-success"></i></a>
                                                            </li>
                                                            @endcan
                                                            
                                                            @can('Xóa lương')
                                                            <li class="list-inline-item px">
                                                                <form method="post" action="{{ route('salaries.destroy', $salary->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    
                                                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Xóa" class="border-0 bg-white"><i class="mdi mdi-trash-can text-danger"></i></button>
                                                                </form>
                                                            </li>
                                                            @endcan
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{ $salaries->links() }}
                            </div>
                        </div>
                    </div>
                </div>
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

    <script type="text/javascript">
        $('#month').datepicker({
            format: 'mm',
        });

        $('#year').datepicker({
            format: 'yyyy',
        });
    </script>
@endpush

@push('css')
    <!-- datepicker css -->
    <link href="{{ asset('libs\bootstrap-datepicker\css\bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs\bootstrap-colorpicker\css\bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('libs\bootstrap-timepicker\css\bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('libs\@chenfengyuan\datepicker\datepicker.min.css') }}">

    <link href="{{ asset('libs\select2\css\select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush