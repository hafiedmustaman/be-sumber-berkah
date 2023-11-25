<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str; // untuk membuat slug untuk data category. Slug digunakan untuk membuat URL yang dihasilkan akan menjadi lebih SEO friendly.
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // untuk proses upload image dari category ke server.

class CategoryController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() // digunakan untuk menampilkan data category yang diambil dari table categories.
    {
        $categories = Category::latest()->when(request()->q, function($categories) {
            $categories = $categories->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.category.index', compact('categories'));
    }
    
    /**
     * create
     *
     * @return void
     */
    public function create() // digunakan untuk menampilkan form tambah data category, dimana di dalam function ini, kita me-return ke sebuah views create category.
    {
        return view('admin.category.create');
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request) // digunakan untuk proses simpan menyimpan data category yang di inputkan melalui form.
    {
       $this->validate($request, [
           'image' => 'required|image|mimes:jpeg,jpg,png|max:2000', // <-- artinya field image wajib diisi, kemudian harus ber-type image, extension yang di izinkan adalah jpg, jpeg dan png. Dan maksimal ukuran gambar yang diupload adalah 2000 Kb / 2 Mb.
           'name'  => 'required|unique:categories' // artinya field name wajib diisi dan field ini bersifat unik atau tidak boleh ada data yang sama.
       ]); 

       //upload image
       $image = $request->file('image');
       $image->storeAs('public/categories', $image->hashName());

       //save to DB
       $category = Category::create([
           'image'  => $image->hashName(),
           'name'   => $request->name,
           'slug'   => Str::slug($request->name, '-')
       ]);

       if($category){
            //redirect dengan pesan sukses
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.category.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function edit(Category $category) // digunakan untuk menampilkan proses edit data di dalam form, dimana di dalam function edit kita tambahkan parameter yang isinya merupakan model Category.
    {
        return view('admin.category.edit', compact('category'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function update(Request $request, Category $category) // digunakan untuk melakukan proses update data category.
    {
        $this->validate($request, [
            'name'  => 'required|unique:categories,name,'.$category->id 
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $category = Category::findOrFail($category->id);
            $category->update([
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-')
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/categories/'.basename($category->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/categories', $image->hashName());

            //update dengan image baru
            $category = Category::findOrFail($category->id);
            $category->update([
                'image'  => $image->hashName(),
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-')
            ]);
        }

        if($category){
            //redirect dengan pesan sukses
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.category.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id) // digunakan untuk menghapus data category dari database.
    {
        $category = Category::findOrFail($id);
        $image = Storage::disk('local')->delete('public/categories/'.basename($category->image));
        $category->delete();

        if($category){
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
