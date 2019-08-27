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
            'cover' => 'required',
            'isi' => 'required',
            'id_kategori' => 'required'
            ]);
        if ($validator->fails()) {
            return redirect()->back()->with('gagal','gagal post berita!');
        }
        else {
            $uploadfile = $request->file('cover');
            $name = time().'.'.$uploadfile->getClientOriginalName();
            $path = $uploadfile->move('wysiwyg',$name);
            $berita = new berita;
            $berita->cover = $name;
            $berita->judul = $request->judul;
            $berita->isi = $request->isi;
            $berita->id_kategori = $request->id_kategori;
            $berita->tanggal = now();
            $berita->save();
            return redirect()->back()->with('sukses','sukses post berita!');
        }
        
    }
    public function berita_controller(){
    //     $berita = berita::orderBy('id_berita', 'DESC')->get();
    return view ('admin/beritacontrol');
    }
    public function berita_del(Request $request){
        // $del = berita::find($id);
        // $del->forceDelete();
        // return redirect()->back()->with('sukses','Berhasil menghapus data!');

        if($request->ajax())
        {
            DB::table('berita')
                ->where('id_berita', $request->id)
                ->delete();
            echo '<div class="alert alert-success">Data Deleted</div>';
        }
    

    }
    public function berita_edit(Request $request,$id){
        $edit = berita::find($id);
        $kategori = kategori::all();  
        $idkat = $edit->id_kategori;
        $b = DB::table('berita')
        ->join('kategori', 'berita.id_kategori', '=', 'kategori.id_kategori')
        ->where('kategori.id_kategori', '=', $idkat)
        ->select('*')
        ->get();
        return view('admin/beritaedit', ['edit' => $edit, 'b' => $b, 'kategori' => $kategori]);
    }
    public function berita_update(Request $request){
        if($request->cover == NULL){
            $id = $request->id_berita;
            $berita = berita::find($id);
            $berita->judul = $request->judul;
            $berita->cover = $request->p;
            $berita->isi = $request->isi;
            $berita->id_kategori = $request->id_kategori;
            $berita->save();
        return redirect()->back()->with('sukses','sukses edit!');
        } else {    
        $uploadfile = $request->file('cover');
        $name = time().'.'.$uploadfile->getClientOriginalName();
        $path = $uploadfile->move('wysiwyg',$name);    
        $id = $request->id_berita;
        $berita = berita::find($id);
        $berita->judul = $request->judul;
        $berita->cover = $name;
        $berita->isi = $request->isi;
        $berita->id_kategori = $request->id_kategori;
        $berita->save();
        return redirect()->back()->with('sukses','sukses edit!');
        }
       

    }
    public function berita_search(Request $request){
    //     if($request->ajax()){
    //         $output="";
    //         $berita=DB::table('berita')->where('judul','LIKE','%'.$request->search."%")->get();
    //         if($berita){
    //             foreach ($berita as $key => $products) {
    //             $output.='<tr>'.
    //             '<td>'.$loop->iteration.'</td>'.
    //             '<td>'.$products->judul.'</td>'.
    //             '<td>'.$products->tanggal.'</td>'.
    //             '<td><a href="/admin/berita/edit/{{$row->id_berita}}"><input type="button" class="btn btn-primary" Value="Edit" name=""></a> <a href="/admin/berita/del/{{$row->id_berita}}"><input type="button" class="btn btn-danger" Value="Delete" onclick="return confirm());" name=""></a></td>'.
    //             '</tr>';
    //         }
    //         return Response($output);
    //         }
    //     }
    // }
       
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('berita')
                ->where('judul', 'like', '%'.$query.'%')
                ->orderBy('id_berita', 'desc')
                ->get();
            }
            else {
                $data = DB::table('berita')
                ->orderBy('id_berita', 'desc')
                ->get();
            }
            $total_row=$data->count();
            if($total_row > 0){
                $i=1;
                foreach ($data as $row) {
                  
                   $output .= '<tr>
                    <td>'.$i++.'</td>
                    <td>'.$row->judul.'</td>
                    <td>'.$row->tanggal.'</td>
                    <td><a href="/admin/berita/edit/'.$row->id_berita.'"><input type="button" class="btn btn-primary" Value="Edit" name=""></a> <button type="button" class="btn btn-danger delete"  id="'.$row->id_berita.'">Delete</button></td>
                    </tr>
                   ';
                }
            }
            else {
                $output = '
                <tr>
                    <td align="center">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row

            );
            echo json_encode($data);
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
