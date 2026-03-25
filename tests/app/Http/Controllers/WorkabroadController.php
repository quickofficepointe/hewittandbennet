<?php

namespace App\Http\Controllers;

use App\Models\workabroad;
use App\Models\hewitt_banners;
use App\Models\courses;
use Illuminate\Http\Request;

class WorkabroadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
        return view('frontendviews.workabroad.index' ,compact('banners','coursese'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(workabroad $workabroad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(workabroad $workabroad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, workabroad $workabroad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(workabroad $workabroad)
    {
        //
    }
}
