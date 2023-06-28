@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Головна сторінка</h2>
            <hr/>
            <form class="mt-3 mb-3" method="GET" action="{{ route('home') }}">
                <h5>
                    Фільтри
                </h5>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label>Тип оголошення</label>
                        <select name="post_type" class="form-select" id="post-type">
                            <option value="" @if ($postTypeFilter === "") {{ 'selected' }} @endif>Виберіть тип оголошення</option>
                            <option value="1" @if ($postTypeFilter === '1') {{ 'selected' }} @endif>Пропозиція</option>
                            <option value="0" @if ($postTypeFilter === '0') {{ 'selected' }} @endif>Потреба</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label>Тип допомоги</label>
                        <input name="tagify" id="tagify" class="form-control" value='{!! $postTagFilter !!}'>
                    </div>
                </div>
                <input type="submit" class="mt-3 btn btn-secondary" value="Відфільтрувати">
            </form>
            @if(count($posts))
                @foreach($posts as $post)
                <div class="card mb-3">
                    <div class="card-header"><strong>{{$post->title}}</strong></div>
                    <div class="card-body">
                        <p><em>Тип оголошення: {{$post->post_type ? 'Пропозиція' : 'Потреба'}}</em></p>
                        <div class="form-group">
                            <label><strong>Тип допомоги: {{$post->tagify}}</strong></label>
                        </div>
                        @if ($post->image_link)
                            <img class="mb-3" src="{{ asset('images/' . $post->image_link) }}" style="width: 300px; height: 300px; object-fit: cover">
                        @endif
                        <p>{{Illuminate\Support\Str::limit($post->description, 200)}}</p>
                        <a class="btn btn-primary mb-2" href="{{ route('show-post', $post->id) }}">Відкрити повну інформацію</a>
                        @auth
                            @if($post->user_id === Auth::user()->id)
                                <a class="btn btn-secondary mb-2" href="{{ route('edit-post', $post->id) }}">Редагувати оголошення</a>
                            @endif
                        @endauth
                    </div>
                </div>
                @endforeach
            @else
            <p>Відсутні активні оголошення</p>
            @endif
        </div>
    </div>
</div>
@endsection
