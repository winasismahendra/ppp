<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\slider;
use App\katadepan;
use App\keunggulan;
use App\album;
use App\kategori;
use App\berita;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    public function berita_add(){
        $kategori = kategori::all();
        return view ('admin/beritaadd',['kategori' => $kategori]);
    }
    public function berita_store(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'isi' => 'required',
            'id_kategori' => 'required'
            ]);
        if ($validator->fails()) {
            return redirect()->back()->with('gagal','gagal post berita!');
        }
        else {
            $berita = new berita;
            $berita->judul = $request->judul;
            $berita->isi = $request->isi;
            $berita->id_kategori = $request->id_kategori;
            $berita->tanggal = now();
            $berita->save();
            return redirect()->back()->with('sukses','sukses post berita!');
        }
        
    }
    public  function    ppdb(){


        return  view    ('master/ppdb');
    }

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
    public function galeri_add(){
        return view('/admin/galeriadd');
    }

    public function galeri_store(Request $request){
        $this->validate($request, [

                'file' =>  'required',
                'file*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
       
         {

            foreach($request->file('file') as $image)
            {
                $name= 'galeri-'.time().'-'.$image->getClientOriginalName();
                $image->move(public_path().'/images/gallery', $name);  
                $data[] = $name;  
            }
         }

         $form = new album();
         $form->foto=json_encode($data);
         
        
        $form->save();

        return back()->with('success', 'Your images has been successfully');
    }
    public function berita_upimage(Request $request){
        $CKEditor = $request->input('CKEditor');
        $funcNum  = $request->input('CKEditorFuncNum');
        $message  = $url = '';
            if (Input::hasFile('upload')) {
                $file = Input::file('upload');
                if ($file->isValid()) {
                    $filename =rand(1000,9999).$file->getClientOriginalName();
                    $file->move(public_path().'/wysiwyg/', $filename);
                    $url = url('wysiwyg/' . $filename);
        } else {
            $message = 'An error occurred while uploading the file.';
        }
    } 
    else {
        $message = 'No file uploaded.';
    }
    return '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';    
    }

}
