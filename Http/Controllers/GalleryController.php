<?php

namespace Modules\Gallery\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Base\Entities\Photo;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Entities\GalleryCategory;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (\request()->session()->has('brand_id')){
            $items = Gallery::where('brand_id', \request()->session()->get('brand_id'))->get();
        }elseif (Auth::user()->brand_id) {
            $items = Gallery::where('brand_id', Auth::user()->brand_id)->get();
        }else {
            $items = Gallery::all();
        }

        return view('gallery::index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (\request()->session()->has('brand_id')){
            $categories = GalleryCategory::where('brand_id', \request()->session()->get('brand_id'))->whereNull('parent_id')->orderBy('sort_id')->get();
        }elseif (Auth::user()->brand_id) {
            $categories = GalleryCategory::where('brand_id', Auth::user()->brand_id)->whereNull('parent_id')->orderBy('sort_id')->get();
        }else {
            $categories = GalleryCategory::whereNull('parent_id')->orderBy('sort_id')->get();
        }

        return view('gallery::create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'lang' => 'required',
            'brand_id' => 'required',
            'title' => 'required',
        ]);
        try {
            $gallery = Gallery::create([
                'lang' => $request->lang,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'text' => $request->text,
                'image' => (isset($request->image)?file_store($request->image, 'assets/uploads/photos/gallery_image/','photo_'):null),
                'banner' => (isset($request->banner)?file_store($request->banner, 'assets/uploads/photos/gallery_banner/','photo_'):null),
            ]);

            if (isset($request->photos)){
                foreach ($request->photos as $photo){
                    $ph = new Photo();
                    $ph->path = file_store($photo, 'assets/uploads/photos/galleries/','photo_');
                    $gallery->photo()->save($ph);
                }
            }

            return redirect()->route('gallery.index')->with('flash_message', 'با موفقیت ثبت شد');
        }catch (\Exception $e){
            return redirect()->back()->withInput()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('gallery::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Gallery $gallery)
    {
        if (\request()->session()->has('brand_id')){
            $categories = GalleryCategory::where('brand_id', \request()->session()->get('brand_id'))->whereNull('parent_id')->orderBy('sort_id')->get();
        }elseif (Auth::user()->brand_id) {
            $categories = GalleryCategory::where('brand_id', Auth::user()->brand_id)->whereNull('parent_id')->orderBy('sort_id')->get();
        }else {
            $categories = GalleryCategory::whereNull('parent_id')->orderBy('sort_id')->get();
        }

        return view('gallery::edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Gallery $gallery)
    {
        try {
            if ($request->lang) {
                $gallery->lang = $request->lang;
            }
            if ($request->brand_id) {
                $gallery->brand_id = $request->brand_id;
            }
            $gallery->category_id = $request->category_id;
            $gallery->title = $request->title;
            $gallery->text = $request->text;
            if (isset($request->image)) {
                if ($gallery->image){
                    File::delete($gallery->image);
                }
                $gallery->image = file_store($request->image, 'assets/uploads/photos/gallery_image/','photo_');
            }

            if (isset($request->banner)){
                if ($gallery->banner){
                    File::delete($gallery->banner);
                }
                $gallery->banner = file_store($request->banner, 'assets/uploads/photos/gallery_banner/', 'photo_');
            }

            $gallery->save();

            if (isset($request->photos)){
                foreach ($request->photos as $photo){
                    $ph = new Photo();
                    $ph->path = file_store($photo, 'assets/uploads/photos/galleries/','photo_');
                    $gallery->photo()->save($ph);
                }
            }

            return redirect()->route('gallery.index')->with('flash_message', 'با موفقیت بروزرسانی شد');
        }catch (\Exception $e){
            return redirect()->back()->withInput()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Gallery $gallery)
    {
        try {
            $gallery->delete();

            return redirect()->back()->with('flash_message', 'با موفقیت حذف شد');
        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function photo_delete($id)
    {
        $photo = Photo::findOrFail($id);
        try {
            $photo->delete();

            return redirect()->back()->with('flash_message', 'با موفقیت حذف شد');
        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }
}
