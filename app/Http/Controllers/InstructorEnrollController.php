<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Course;
use Auth;
use App\RefundCourse;

class InstructorEnrollController extends Controller
{
    public function index()
    {
    	$refunds = RefundCourse::get();
        $orders = Order::where('instructor_id', Auth::User()->id)->get();
        return view('admin.order.show', compact('orders', 'refunds'));
    }
}
