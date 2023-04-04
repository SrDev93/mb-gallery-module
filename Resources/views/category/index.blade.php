@extends('layouts.admin')
@push('stylesheets')
    <link rel="stylesheet" href="{{ my_asset('assets/admin/css/nestable.css') }}">
@endpush
@section('content')
    <!-- CONTAINER -->
    <div class="main-container container-fluid">


    @include('gallery::category.partial.header')

        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">لیست دسته بندی ها</h3>
                    </div>
                    <div class="card-body">
                        <div class="body-content">
                            <div class="dd">
                                <ol class="dd-list">
                                    @foreach($categories as $category)
                                        <li class="dd-item" draggable="true" data-id="{{ $category->id }}">
                                            <div class="dd-handle">@if(!\Illuminate\Support\Facades\Auth::user()->brand_id) {{ optional($category->brand)->name }} - @endif {{ $category->name }}</div>
                                            <div class="btn-inline">
                                                <a class="btn btn-primary" href="{{ route('GalleryCategory.edit', $category->id) }}" title="ویرایش"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('GalleryCategory.destroy', $category->id) }}" method="post" class="delete-form">
                                                    <button class="delete btn btn-danger" onclick="return confirm('برای حذف اطمینان دارید؟')"><i class="fa fa-trash"></i></button>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                            @include('gallery::category.each', $category)
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('GalleryCategory.create') }}" class="btn btn-primary">افزودن دسته بندی</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
    @push('scripts')
{{--        <script type="text/javascript" src="{{ my_asset('assets/admin/js/nestable.min.js') }}"></script>--}}
{{--        <script type="text/javascript">--}}
{{--            $('.dd').nestable();--}}
{{--            $('.dd').on('change', function () {--}}
{{--                $.post('{{ route('NewsCategory-sort') }}', {--}}
{{--                    sort: JSON.stringify($('.dd').nestable('serialize')),--}}
{{--                    _token: '{{ csrf_token() }}'--}}
{{--                }, function () {--}}
{{--                    $.jGrowl('ذخیره شد', {life: 3000, position: 'bottom-left', theme: 'bg-success'});--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}
    @endpush
@endsection
