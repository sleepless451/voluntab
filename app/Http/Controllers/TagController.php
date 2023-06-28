<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function create()
    {
        if(\Auth::check()){
            return view('tag.create');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag = new Tag([
            'name' => $request->name,
        ]);
        $tag->save();

        return redirect()->route('tags-dashboard');
    }

    public function edit(Tag $tag)
    {
        return view('tag.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag->name = $request->name;
        $tag->save();

        return redirect()->route('tags-dashboard');
    }

    public function delete(Tag $tag)
    {
        $tag->delete();
        return redirect()->back();
    }
}
