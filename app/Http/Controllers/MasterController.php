<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\slider;


class MasterController extends Controller
{
    
	public function index()
    {
    	
        $slider = slider::all();
    	return view('master/index',['slider' => $slider]); 
    
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
}
