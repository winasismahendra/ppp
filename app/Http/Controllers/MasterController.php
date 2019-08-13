<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\slider;
use App\katadepan;
use App\keunggulan;
use App\galeri;


class MasterController extends Controller
{
    
	public function index()
    {
    	
        $slider = slider::all();
        $katadepan = katadepan::all();
        $keunggulan = keunggulan::all();
    	return view('master/index',['slider' => $slider, 'katadepan' => $katadepan, 'keunggulan' => $keunggulan]); 
    
    }

    public function tkj()
    {
    	

    	return view('master/tkj'); 
    
    }

    public function perbankan()
    {
    	

    	return view('master/perbankan'); 
    
    }

    public function multimedia()
    {
    	

    	return view('master/multimedia'); 
    
    }
    public function galeri(){
        $galeri = galeri::all();
        return view('master/galeri',['galeri' => $galeri]);
    }
}
