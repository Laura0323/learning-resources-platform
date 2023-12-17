<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Resources', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resources' => Resource::with('category')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
        Resource::create([
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'creator_id' => $request->user()->id,
        ]);

        return Inertia::location('/');
    }

    public function search(Request $request)
    {
        return Resource::where('title', 'like', "%$request->search%")
        //->orWhere('description', 'like', "%$request->search%")
        ->with('category')
        ->get();
    }
}
  