<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::with('category')->get();
        $categories = Category::withCount('tickets')->get();

        return view('admins.dashboard.index', compact('tickets', 'categories'));
    }
}
