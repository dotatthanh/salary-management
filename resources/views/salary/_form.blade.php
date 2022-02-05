@csrf
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="user_id">Tên nhân viên <span class="text-danger">*</span></label>
            <select {{ isset($routeUpdate) ? 'disabled' : '' }} class="form-control select2" name="user_id" onchange="getInsuranceCard($(this).val())">
                <option value="">Chọn nhân viên</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ isset($data_edit->user_id) && $data_edit->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            {!! $errors->first('user_id', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label for="paid_day_off">Ngày nghỉ phép <span class="text-danger">*</span></label>
            <input id="paid_day_off" name="paid_day_off" type="number" class="form-control" placeholder="Ngày nghỉ phép" value="{{ old('paid_day_off', $data_edit->paid_day_off ?? '') }}">
            {!! $errors->first('paid_day_off', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label for="unpaid_day_off">Ngày nghỉ không phép <span class="text-danger">*</span></label>
            <input id="unpaid_day_off" name="unpaid_day_off" type="number" class="form-control" placeholder="Ngày nghỉ không phép" value="{{ old('unpaid_day_off', $data_edit->unpaid_day_off ?? '') }}">
            {!! $errors->first('unpaid_day_off', '<span class="error">:message</span>') !!}
        </div>

    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="month">Tháng <span class="text-danger">*</span></label>
            <div class="docs-datepicker">
                <div class="input-group">
                    <input type="text" class="form-control docs-date" id="month" name="month" placeholder="Chọn tháng" autocomplete="off" value="{{ old('month', isset($data_edit->month) ? $data_edit->month : '') }}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger" disabled="">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="docs-datepicker-container"></div>
            </div>
            {!! $errors->first('month', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label for="year">Năm <span class="text-danger">*</span></label>
            <div class="docs-datepicker">
                <div class="input-group">
                    <input type="text" class="form-control docs-date" id="year" name="year" placeholder="Chọn năm" autocomplete="off" value="{{ old('year', isset($data_edit->year) ? $data_edit->year : '') }}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger" disabled="">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="docs-datepicker-container"></div>
            </div>
            {!! $errors->first('year', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label for="total_working_days">Tổng số ngày làm việc <span class="text-danger">*</span></label>
            <input id="total_working_days" name="total_working_days" type="number" class="form-control" placeholder="Tổng số ngày làm việc" value="{{ old('total_working_days', $data_edit->total_working_days ?? '') }}">
            {!! $errors->first('total_working_days', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
            <label for="salary">Tổng tiền lương (VND) <span class="text-danger">*</span></label>
            <input id="salary" name="salary" type="number" class="form-control" placeholder="Tổng tiền lương" value="{{ old('salary', $data_edit->salary ?? '') }}">
            {!! $errors->first('salary', '<span class="error">:message</span>') !!}
        </div>
        
    </div>
</div>

<button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">Lưu lại</button>
<a href="{{ route('salaries.index') }}" class="btn btn-secondary waves-effect">Quay lại</a>