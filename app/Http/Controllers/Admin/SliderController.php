<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider; // untuk memanipulasi data ke dalam database.
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // untuk melakukan upload file gambar slider nantinya ke dalam server.

class SliderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() // digunakan untuk menampilkan data slider dari database.
    {
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index', compact('sliders'));
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request) // digunakan untuk melakukan proses insert data ke dalam database.
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            /*
            rule "required" digunakan untuk memastikan bahwa field/kolom tidak boleh kosong.
            rule "image" digunakan untuk memastikan bahwa filed/kolom yang digunakan adalah bertipe gambar.
            rule "mimes" digunakan untuk memvalidasi extension file yang akan di upload, di atas contohnya adalah jpeg, jpg, png.
            rule "max:2000" digunakan untuk memvalidasi maksimal ukuran file sebelum di upload, di atas kita atur dengan 2000, yang artinya adalah 2 Mb.
            */
            'link'  => 'required' 
        ]); 
 
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());
 
        //save to DB
        $slider = Slider::create([
            'image'  => $image->hashName(),
            'link'   => $request->link
        ]);
 
        if($slider){
             //redirect dengan pesan sukses
             return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Disimpan!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Disimpan!']);
         }
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id) // digunakan untuk menghapus data slider dan file gambar dari database.
    {
        $slider = Slider::findOrFail($id);
        $image = Storage::disk('local')->delete('public/sliders/'.basename($slider->image));
        $slider->delete();

        if($slider){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
