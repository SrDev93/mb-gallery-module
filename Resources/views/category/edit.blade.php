@extends('layouts.admin')

@section('content')
    <!-- CONTAINER -->
    <div class="main-container container-fluid">

    @include('gallery::category.partial.header')

    <!-- ROW -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">ویرایش دسته بندی</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('GalleryCategory.update', $GalleryCategory->id) }}" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                            @include('admin.partial.lang')
                            @include('admin.partial.brand')
                            <div class="col-md-12">
                                <label for="name" class="form-label">نام دسته بندی</label>
                                <input type="text" name="name" class="form-control" id="name" required value="{{ $GalleryCategory->name }}">
                                <div class="invalid-feedback">لطفا نام دسته بندی را وارد کنید</div>
                            </div>

{{--                            <div class="col-md-5">--}}
{{--                                <label for="icon" class="form-label">آیکن (40 * 40)</label>--}}
{{--                                <input type="file" name="icon" class="form-control" id="icon" accept="image/*">--}}
{{--                                <div class="invalid-feedback">لطفا آیکن را انتخاب کنید</div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-1">--}}
{{--                                @if($GalleryCategory->icon)--}}
{{--                                    <label for="icon" class="form-label">آیکن فعلی</label>--}}
{{--                                    <img src="{{ url($GalleryCategory->icon) }}" style="max-width: 100%;">--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <label for="slug" class="form-label">نامک</label>--}}
{{--                                <input type="text" name="slug" class="form-control" id="slug" required value="{{ $GalleryCategory->slug }}">--}}
{{--                                <div class="invalid-feedback">لطفا نامک را وارد کنید</div>--}}
{{--                            </div>--}}
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">ارسال فرم</button>
                                @csrf
                                @method('PATCH')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW CLOSED -->


    </div>
@endsection
