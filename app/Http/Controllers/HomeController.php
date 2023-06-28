<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $postTypeFilter = is_null($request->post_type) ? "" : $request->post_type;
        $postTagFilter = is_null($request->tagify) ? "" : $request->tagify;
        $postTagsFilter = [];

        $activePosts = Post::query()->where('status', Post::STATUS_ACTIVE);

        if($postTagFilter !== ""){
            $postTagFilterDecoded = json_decode($postTagFilter, true);
            foreach($postTagFilterDecoded as $item){
                array_push($postTagsFilter, $item['slug']);
            }

            $activePosts = $activePosts->whereHas('postTags', function ($query) use ($postTagsFilter){
                $query->whereIn('tag_id', $postTagsFilter);
            });
        }

        if($postTypeFilter !== ""){
            $activePosts = $activePosts->where('post_type', $postTypeFilter);
        }

        $activePosts = $activePosts->get();

        foreach($activePosts as $post) {
            $tags = Tag::get();
            $jsonTags = [];
            foreach($post->postTags as $postTag){
                $tag = $tags->filter(function($item) use ($postTag) {
                    return $item->id == $postTag->tag_id;
                })->first();
    
                array_push($jsonTags, $tag->name);
            }
            $post->tagify = implode(", ", $jsonTags);
        }

        return view('home', ['posts' => $activePosts, 'postTypeFilter' => $postTypeFilter, 'postTagFilter' => $postTagFilter]);
    }
}
