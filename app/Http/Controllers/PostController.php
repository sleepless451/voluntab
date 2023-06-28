<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostTag;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function show(Post $post)
    {
        $tags = Tag::get();
        $jsonTags = [];
        foreach($post->postTags as $postTag){
            $tag = $tags->filter(function($item) use ($postTag) {
                return $item->id == $postTag->tag_id;
            })->first();

            array_push($jsonTags, $tag->name);
        }
        $post->tagify = implode(", ", $jsonTags);

        return view('post.show', compact('post'));
    }

    public function create()
    {
        if(Auth::check()){
            return view('post.create');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'post_type' => 'required',
            'tagify' => 'required',
            'description' => 'required|string',
            'is_map' => 'nullable',
            'map_long' => 'required',
            'map_lat' => 'required',
            'contact_info' => 'required|string|max:255',
            'image_link' => 'image|mimes:jpeg,png,jpg|max:2048'
        ], ['tagify.required' => 'The Tags field is required.']);

        $user = Auth::user();

        $is_map = (boolean)$request->is_map;
        $map_long = null;
        $map_lat = null;

        if ($is_map) {
            $map_long = $request->map_long;
            $map_lat = $request->map_lat;
        }

        if ($request->hasFile('image_link')) {
            $path = Storage::disk('images')
                ->put('/', $request->file('image_link'));
        }

        $post = new Post([
            'user_id' => $user->id,
            'title' => $request->title,
            'post_type' => $request->post_type,
            'status' => Post::STATUS_ACTIVE,
            'description' => $request->description,
            'is_map' => $is_map,
            'map_long' => $map_long,
            'map_lat' => $map_lat,
            'contact_info' => $request->contact_info,
            'image_link' => $path ?? null
        ]);
        $post->save();

        $tags = is_null($request->tagify) ? "" : $request->tagify;
        if($tags !== ""){
            $tagsDecoded = json_decode($tags, true);
            foreach($tagsDecoded as $item){
                $postTag = new PostTag([
                    'post_id' => $post->id,
                    'tag_id' => $item['slug'],
                ]);
                $postTag->save();
            }
        }

        //return redirect()->route('post.show', $post);

        return redirect()->route('home');
    }

    public function edit(Post $post)
    {
        $tags = Tag::get();
        $jsonTags = [];
        foreach($post->postTags as $postTag){
            $tag = $tags->filter(function($item) use ($postTag) {
                return $item->id == $postTag->tag_id;
            })->first();

            array_push($jsonTags, ['slug' => $tag->id, 'value' => $tag->name]);
        }
        $post->tagify = json_encode($jsonTags, JSON_UNESCAPED_UNICODE);

        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'post_type' => 'required',
            'tagify' => 'required',
            'description' => 'required|string',
            'is_map' => 'nullable',
            'map_long' => 'required',
            'map_lat' => 'required',
            'contact_info' => 'required|string|max:255',
            'image_link' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], ['tagify.required' => 'The Tags field is required.']);

        if ($request->hasFile('image_link')) {
            $path = Storage::disk('images')
                ->put('/', $request->file('image_link'));

            $old_path = $post->image_link;

            if(!filter_var($old_path, FILTER_VALIDATE_URL)){
                Storage::disk('images')->delete($old_path);
            }

            $post->image_link = $path;
        }

        $is_map = (boolean)$request->is_map;
        $map_long = null;
        $map_lat = null;

        if ($is_map) {
            $map_long = $request->map_long;
            $map_lat = $request->map_lat;
        }

        $post->title = $request->title;
        $post->post_type = $request->post_type;
        $post->description = $request->description;
        $post->is_map = $is_map;
        $post->map_long = $map_long;
        $post->map_lat = $map_lat;
        $post->contact_info = $request->contact_info;
        $post->save();

        PostTag::where('post_id', $post->id)->delete();
        $tags = is_null($request->tagify) ? "" : $request->tagify;
        if($tags !== ""){
            $tagsDecoded = json_decode($tags, true);
            foreach($tagsDecoded as $item){
                $postTag = new PostTag([
                    'post_id' => $post->id,
                    'tag_id' => $item['slug'],
                ]);
                $postTag->save();
            }
        }

        return redirect()->route('home');
    }

    public function showUserPosts(User $user)
    {
        $posts = Post::where('user_id', $user->id)->get();
        return view('post.user-posts', ['posts' => $posts]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $posts = Post::searchPost('title',$search)->get();
        return view('post.search', ['posts' => $posts]);
    }

    public function setInactivePost(Post $post)
    {
        $post->status = Post::STATUS_INACTIVE;
        $post->save();
        return redirect()->back()->with('success', 'Оголошенню встановлено статус - Деактивоване');
    }

    public function setSuccessPost(Post $post)
    {
        $post->status = Post::STATUS_SUCCESS;
        $post->save();
        return redirect()->back()->with('success', 'Оголошенню встановлено статус - Успішне');
    }

    public function setActivePost(Post $post)
    {
        $post->status = Post::STATUS_ACTIVE;
        $post->save();
        return redirect()->back()->with('success', 'Оголошенню встановлено статус - Активне');
    }
}
