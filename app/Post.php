<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_SUCCESS = 3;

    CONST POST_TYPE_LOST = 0;
    CONST POST_TYPE_FOUND = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'post_type', 'title' , 'status', 'name', 'description', 'is_map', 'map_long', 'map_lat', 'contact_info', 'image_link'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function postTags()
    {
        return $this->hasMany(PostTag::class, 'post_id', 'id');
    }

    public function scopeSearchPost($query, $column, $value)
    {
        return $query->where($column, 'like', '%'.$value.'%');
    }
}
