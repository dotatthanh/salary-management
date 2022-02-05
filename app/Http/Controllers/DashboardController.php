<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Salary;

class DashboardController extends Controller
{
    public function index()
    {
    	$count_users = User::count();
    	$total_salary = Salary::where('month', date('m'))->orWhere('month', date('Y'))->count();

    	$data = [
    		'count_users' => $count_users,
    		'total_salary' => $total_salary,
    	];

    	return view('dashboard', $data);
    }
}
