<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showPostsDashboard(Request $request)
    {
        $postTypeFilter = is_null($request->post_type) ? "" : $request->post_type;
        $postTagFilter = is_null($request->tagify) ? "" : $request->tagify;
        $postStatusFilter = is_null($request->post_status) ? "" : $request->post_status;
        $postTagsFilter = [];
        $posts = Post::query();
        if($postTypeFilter !== ""){
            $posts = $posts->where('post_type', $postTypeFilter);
        }
        if($postTagFilter !== ""){
            $postTagFilterDecoded = json_decode($postTagFilter, true);
            foreach($postTagFilterDecoded as $item){
                array_push($postTagsFilter, $item['slug']);
            }

            $posts = $posts->whereHas('postTags', function ($query) use ($postTagsFilter){
                $query->whereIn('tag_id', $postTagsFilter);
            });
        }
        if($postStatusFilter !== ""){
            $posts = $posts->where('status', $postStatusFilter);
        }
        $posts = $posts->get();
        return view('admin.posts-dashboard', ['posts' => $posts, 'postTypeFilter' => $postTypeFilter, 'postTagFilter' => $postTagFilter, 'postStatusFilter' => $postStatusFilter]);
    }

    public function showUsersDashboard(Request $request)
    {
        $userRoleFilter = is_null($request->user_role) ? "" : $request->user_role;
        $users = User::query();
        if($userRoleFilter !== ""){
            $users = $users->where('role', $userRoleFilter);
        }
        $users = $users->get();
        return view('admin.users-dashboard', ['users' => $users, 'userRoleFilter' => $userRoleFilter]);
    }

    public function showTagsDashboard()
    {
        $tags = Tag::get();

        return view('admin.tags-dashboard', ['tags' => $tags]);
    }

    public function setAdminRole(User $user)
    {
        $user->role = User::ROLE_ADMIN;
        $user->save();
        return redirect()->back()->with('success', 'Встановлено роль - Адмін');
    }

    public function setUserRole(User $user)
    {
        $user->role = User::ROLE_USER;
        $user->save();
        return redirect()->back()->with('success', 'Встановлено роль - користувач');
    }
}
