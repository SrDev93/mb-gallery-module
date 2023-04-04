<?php

namespace Modules\Gallery\Entities;

use App\Models\Brand;
use App\Models\Language;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryCategory extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function parent()
    {
        return $this->hasOne(GalleryCategory::class, 'parent_id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function language()
    {
        return $this->hasOne(Language::class, 'lang', 'lang');
    }

    public function children()
    {
        return $this->hasMany(GalleryCategory::class, 'parent_id')->with('children');
    }

    public function galleries() {
        return $this->hasMany(Gallery::class, 'category_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected static function newFactory()
    {
        return \Modules\Gallery\Database\factories\GalleryCategoryFactory::new();
    }
}
