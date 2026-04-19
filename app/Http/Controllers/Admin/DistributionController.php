<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distribusi;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribusi::with('feedbacks')
            ->paginate(10);
        
        return view('admin.distributions.index', compact('distributions'));
    }
}
