<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalaryRequest;
use App\Http\Requests\UpdateSalaryRequest;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SalariesImport;
use App\Exports\SalariesExport;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $salaries = Salary::where('month', date('m'))->orWhere('month', date('Y'));

        if(isset($request->name) || isset($request->month) || isset($request->year)) {
            $salaries = Salary::query();

            if (isset($request->name)) {
                $name = $request->name;
                $salaries = $salaries->whereHas('user', function($query) use ($name)
                {
                    $query->where('name', 'like', '%'.$name.'%');
                });
            }

            if (isset($request->month)) {
                $salaries = $salaries->where('month', $request->month);
            }

            if (isset($request->year)) {
                $salaries = $salaries->where('year', $request->year);
            }
        }


        $salaries = $salaries->paginate(10);
        $salaries->appends([
            'name' => $request->name,
            'month' => $request->month,
            'year' => $request->year,
        ]);

        $data = [
            'salaries' => $salaries,
            'request' => $request,
        ];

        return view('salary.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        $data = [
            'users' => $users,
        ];

        return view('salary.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalaryRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $month = str_pad($request->month, 2, '0', STR_PAD_LEFT);

            $check = Salary::where('user_id', $request->user_id)->Where('month', $month)->Where('year', $request->year)->exists();
            if ($check) {
                $user = User::findOrFail($request->user_id);

                return redirect()->back()->with('alert-error','Thêm lương thất bại! Nhân viên '. $user->name .' đã có dữ liệu lương tháng '. $month .' năm'. $request->year);
            }

            $create = Salary::create([
                'user_id' => $request->user_id,
                'paid_day_off' => $request->paid_day_off,
                'unpaid_day_off' => $request->unpaid_day_off,
                'total_days_off' => $request->paid_day_off + $request->unpaid_day_off,
                'total_working_days' => $request->total_working_days,
                'salary' => $request->salary,
                'month' => $month,
                'year' => $request->year,
            ]);
            
            DB::commit();
            return redirect()->route('salaries.index')->with('alert-success','Thêm lương thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Thêm lương thất bại!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        $users = User::all();

        $data = [
            'data_edit' => $salary,
            'users' => $users,
        ];

        return view('salary.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalaryRequest $request, Salary $salary)
    {
        try {
            DB::beginTransaction();

            $month = str_pad($request->month, 2, '0', STR_PAD_LEFT);

            $check = Salary::whereNotIn('month', [$salary->month])->where('user_id', $salary->id)->Where('month', $month)->Where('year', $request->year)->exists();
            if ($check) {
                return redirect()->back()->with('alert-error','Sửa lương thất bại! Nhân viên '. $salary->user->name .' đã có dữ liệu lương tháng '. $month .' năm'. $request->year);
            }

            $salary->update([
                'paid_day_off' => $request->paid_day_off,
                'unpaid_day_off' => $request->unpaid_day_off,
                'total_days_off' => $request->paid_day_off + $request->unpaid_day_off,
                'total_working_days' => $request->total_working_days,
                'salary' => $request->salary,
                'month' => $month,
                'year' => $request->year,
            ]);
            
            DB::commit();
            return redirect()->route('salaries.index')->with('alert-success','Sửa lương thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Sửa lương thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        try {
            DB::beginTransaction();

            Salary::destroy($salary->id);
            
            DB::commit();
            return redirect()->route('salaries.index')->with('alert-success','Xóa lương thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Xóa lương thất bại!');
        }
    }


    public function exportExcel() {
        return Excel::download(new SalariesExport(), 'import_salary.xlsx');
    }

    public function importExcel(Request $request) {
        $import = new SalariesImport();
        $import->import($request->file('file'), null, 'Xlsx');

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return back()->with('alert-success', 'Nhập danh sách lương thành công.');
    }
}
