<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product; // untuk memanipulasi data ke dalam database.
use App\Models\Category; // untuk menampilkan pilihan data category saat proses insert dan edit data product.
use Illuminate\Support\Str; // digunakan untuk membuat slug URL dari product menjadi lebih SEO frindly.
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // digunakan untuk melakukan proses upload file gambar product ke dalam server.

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() // digunakan untuk proses menampilkan data product dari table products.
    {
        $products = Product::latest()->when(request()->q, function($products) {
            $products = $products->where('title', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.product.index', compact('products'));
    }
    
    /**
     * create
     *
     * @return void
     */
    public function create() // digunakan untuk menampilkan form untuk proses menambahkan data product ke dalam database.
    {
        $categories = Category::latest()->get();
        return view('admin.product.create', compact('categories'));
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request) // digunakan untuk melakukan proses insert data ke database, dimana data tersebut di dapatkan dari form input product.
    {
       $this->validate($request, [
           'image'          => 'required|image|mimes:jpeg,jpg,png|max:2000',           
           'title'          => 'required|unique:products',
            /*
            arti dari rule "required" adalah field/kolom tersebut wajib diisi dan tidak boleh kosong.
            arti dari rule "image" adalah field/kolom tersebut harus berupa file gambar.
            arti dari rule "mimes" adalah field/kolom tersebut harus sesuai dengan extension yang di tentukan, di atas contohnya adalah jpeg, jpg, png.
            arti dari rule "max:2000" adalah field/kolom tersebut maksimal file yang di unggah adalah 2000 Kb / 2 Mb.
            arti dari rule "unique:products" adalah field/kolom tersebut harus unik dan tidak boleh ada yang sama di dalam table products.
            */ 
           'category_id'    => 'required',
           'content'        => 'required',
           'weight'         => 'required',
           'price'          => 'required',
           'discount'       => 'required',
       ]); 

       //upload image
       $image = $request->file('image');
       $image->storeAs('public/products', $image->hashName());

       //save to DB
       $product = Product::create([
           'image'          => $image->hashName(),
           'title'          => $request->title,
           'slug'           => Str::slug($request->title, '-'),
           'category_id'    => $request->category_id,
           'content'        => $request->content,
           'unit'           => $request->unit,
           'weight'         => $request->weight,
           'price'          => $request->price,
           'discount'       => $request->discount,
           'keywords'       => $request->keywords,
           'description'    => $request->description
       ]);

       if($product){
            //redirect dengan pesan sukses
            return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.product.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * edit
     *
     * @param  mixed $product
     * @return void
     */
    public function edit(Product $product) // digunakan untuk proses menampilkan data product yang akan diupdate.
    {
        $categories = Category::latest()->get();
        return view('admin.product.edit', compact('product', 'categories'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $product
     * @return void
     */
    public function update(Request $request, Product $product) // digunakan untuk melakukan proses update data product ke dalam database.
    {
       $this->validate($request, [
           'title'          => 'required|unique:products,title,'.$product->id,
           'category_id'    => 'required',
           'content'        => 'required',
           'weight'         => 'required',
           'price'          => 'required',
           'discount'       => 'required',
       ]); 

       //cek jika image kosong
       if($request->file('image') == '') {

            //update tanpa image
            $product = Product::findOrFail($product->id);
            $product->update([
                'title'          => $request->title,
                'slug'           => Str::slug($request->title, '-'),
                'category_id'    => $request->category_id,
                'content'        => $request->content,
                'unit'           => $request->unit,
                'weight'         => $request->weight,
                'price'          => $request->price,
                'discount'       => $request->discount,
                'keywords'       => $request->keywords,
                'description'    => $request->description
            ]);

       } else {

            //hapus image lama
            Storage::disk('local')->delete('public/products/'.basename($product->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //update dengan image
            $product = Product::findOrFail($product->id);
            $product->update([
                'image'          => $image->hashName(),
                'title'          => $request->title,
                'slug'           => Str::slug($request->title, '-'),
                'category_id'    => $request->category_id,
                'content'        => $request->content,
                'unit'           => $request->unit,
                'weight'         => $request->weight,
                'price'          => $request->price,
                'discount'       => $request->discount,
                'keywords'       => $request->keywords,
                'description'    => $request->description
            ]);
       }

       if($product){
            //redirect dengan pesan sukses
            return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.product.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id) // digunakan untuk proses hapus data product dari database.
    {
        $product = Product::findOrFail($id);
        $image = Storage::disk('local')->delete('public/products/'.basename($product->image));
        $product->delete();

        if($product){
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
