<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class post extends Model
{
    use HasFactory,SoftDeletes;
    public function tagsRelation(){
        return $this->belongsToMany(Tag::class , 'post_tags', 'post_id', 'tag_id')->withTimestamps();
    }

    public function categoryRelation(){
        return $this->belongsTo(Category::class,'post_category','id');
    }
    public function SubCategoryRelation(){
        return $this->belongsTo(SubCategory::class,'post_subCategory','id');
    }
}
