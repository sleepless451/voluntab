<?php

namespace App\Http\View\Composers;

use App\Tag;
use Illuminate\View\View;

class AppLayoutComposer
{
    protected $tags;

    /**
     * Create a new profile composer.
     *
     * @param App/Models/User $user
     */
    public function __construct()
    {
        $this->tags = Tag::get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('tags', $this->tags);
    }
}
