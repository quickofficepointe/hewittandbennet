<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hewitt_banners;
use App\Models\courses;
class aboutcontroller extends Controller
{
    public function aboutCaptain(){
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
return view('frontendviews.abouts.captain.index',compact('banners','coursese'));
    }

    public function aboutdean(){
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
        return view('frontendviews.abouts.dean.index',compact('banners', 'coursese'));
    }

    public function aboutprincipal(){
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
        return view('frontendviews.abouts.principal.index',compact('banners', 'coursese'));
    }

    public function aboutdirector(){
        $banners = hewitt_banners::where('status', true)->get();
        $coursese = courses::all();
        return view('frontendviews.abouts.director.index',compact('banners', 'coursese'));
    }
}
