<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = item::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();
            
        return view('home', compact('products'));
    }
}
