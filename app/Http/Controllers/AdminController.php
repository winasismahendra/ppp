<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\slider;
use App\katadepan;
use App\keunggulan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
class AdminController extends Controller
{
   
    public  function    coba(){


        return  view    ('admin/index');
    }


	public function index()
    {
    	$slider = slider::all();
    	$katadepan = katadepan::find(3);

    	return view('admin/slidebar',['slider' => $slider, 'katadepan' => $katadepan]);  
    
    }


    public function slidebar()
    {
    	

    	return view('admin/slidebar'); 
    
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

    		return redirect()->back()->with('gagal','gambar belom diisi');
    	}

    	else{

    	$name = time().'.'.$uploadedFile->getClientOriginalName();

        $path = $uploadedFile->move('gambar/slider',$name);

    	}


       
        

        	$slider= new slider;

        	$slider->judul = $request->judul;
        	
           
            $slider->gambar = $name;
			$slider->deskripsi = $request->keterangan;
            

			$slider->save();
			return redirect()->back()->with('success','sukses!');
			
    	 // $check->$slider->save();  

  //   	 if ($validation->fails() && $uploadedFile == NULL) {
  			
  // 			return redirect()->back()->with('gagal','gagal upload');
		// }else {
		// 	return redirect()->back()->with('success','sukses!');
		// 	$slider->save();
		// }

    	// if(!$check){
    	// 	return redirect()->back()->with('gagal','gagal!');
    	// }
    	// else {
    	// 	return redirect()->back()->with('success','data berhasil ditambah!');
    	// }
    
    }

    public function slider_del(Request $request,$id){

    	$hapus = slider::find($id);

    	$path = public_path()."/gambar/slider/".$hapus->gambar;
		unlink($path);
    	$hapus -> forceDelete();

    	return redirect('/admin');

    }

    public function slider_edit($id){


    	$edit = slider::find($id);




    }


     public function kata_up(Request $request)
    {
    	$validation = Validator::make($request->all(),[
    		'judul' => 'required',
    		'isi' => 'required|max:300'
    		]);



        $kata=  katadepan::find(3) ;

        	$kata->judul = $request->judul;
        	    
            $kata->isi = $request->isi;
			
           			$kata->save();
           			return redirect()->back()->with('success','sukses!');
             
    }

      public function keunggulan_up(Request $request)
    {
    	$validation = Validator::make($request->all(),[
    		'judul' => 'required',
    		'deskripsi' => 'required',
    		'judul_label' => 'required',
    		'isi_label' => 'required',
    		
    		]);



        $unggul= new keunggulan ;

        	$unggul->judul = $request->judul;
        	$unggul->deskripsi = $request->deskripsi;
        	$unggul->subjudul = $request->judul_label;
        	$unggul->isi = $request->isi_label;
        	$unggul->icon = $request->icon;
			
        $unggul->save();

           			return redirect()->back()->with('success','sukses!');
             
    }



}
