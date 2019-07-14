<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\slider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
class AdminController extends Controller
{
   
	public function index()
    {
    	

    	return view('admin/slidebar'); 
    
    }


    public function slidebar()
    {
    	

    	return view('layout/amaster'); 
    
    }

     public function slider_up(Request $request)
    {
    	$validation = Validator::make($request->all(),[
    		'judul' => 'required',
    		'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
    		'keterangan' => 'required|max:300'
    		]);

    	$uploadedFile = $request->file('file'); 

    	if ($uploadedFile == NULL){

    		$name = 'kosong';
    	}

    	else{

    			 $name = time().'.'.$uploadedFile->getClientOriginalName();

        $path = $uploadedFile->move('gambar/slider',$name);

    	}


       
        

        $slider= new slider;

        	$slider->judul = $request->judul;
        	
           
            $slider->gambar = $name;
			$slider->deskripsi = $request->keterangan;
            

    	 // $check->$slider->save();  
    	 if ($validation->fails() && $uploadedFile == NULL) {
  			
  			return redirect()->back()->with('gagal','gagal upload');
		}else {
			return redirect()->back()->with('success','sukses!');
			$slider->save();
		}

    	// if(!$check){
    	// 	return redirect()->back()->with('gagal','gagal!');
    	// }
    	// else {
    	// 	return redirect()->back()->with('success','data berhasil ditambah!');
    	// }
    
    }


}
