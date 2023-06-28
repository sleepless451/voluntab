@extends('layouts.app')

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Адмін панель постів</h2>
                <hr/>
                <form class="mt-3 mb-3" method="GET" action="{{ route('posts-dashboard') }}">
                    <h5>
                        Фільтри
                    </h5>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label>Тип оголошення</label>
                            <select name="post_type" class="form-select">
                                <option value="" @if ($postTypeFilter === "") {{ 'selected' }} @endif>Виберіть тип оголошення</option>
                                <option value="1" @if ($postTypeFilter === '1') {{ 'selected' }} @endif>Пропозиція</option>
                                <option value="0" @if ($postTypeFilter === '0') {{ 'selected' }} @endif>Потреба</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label>Тип допомоги</label>
                            <input name="tagify" id="tagify" value='{!! $postTagFilter !!}'>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label>Статус оголошення</label>
                            <select name="post_status" class="form-select">
                                <option value="" @if (old('post_status', $postStatusFilter) === "") {{ 'selected' }} @endif>Виберіть статус оголошення</option>
                                <option value="{{\App\Post::STATUS_ACTIVE}}" @if (old('post_status', $postStatusFilter) == \App\Post::STATUS_ACTIVE) {{ 'selected' }} @endif>Активне</option>
                                <option value="{{\App\Post::STATUS_INACTIVE}}" @if (old('post_status', $postStatusFilter) == \App\Post::STATUS_INACTIVE) {{ 'selected' }} @endif>Деактивоване</option>
                                <option value="{{\App\Post::STATUS_SUCCESS}}" @if (old('post_status', $postStatusFilter) == \App\Post::STATUS_SUCCESS) {{ 'selected' }} @endif>Успішне</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" class="mt-3 btn btn-secondary" value="Відфільтрувати">
                </form>
                @if(count($posts))
                    @foreach($posts as $post)
                        <div class="card mb-3">
                            <div class="card-header"><strong>{{$post->title}}</strong></div>
                            <div class="card-body">
                                @if($post->status === \App\Post::STATUS_ACTIVE)
                                    <p>Статус оголошення: Активне</p>
                                @elseif($post->status === \App\Post::STATUS_INACTIVE)
                                    <p>Статус оголошення: Деактивовано</p>
                                @elseif($post->status === \App\Post::STATUS_SUCCESS)
                                    <p>Статус оголошення: Успіше</p>
                                @endif
                                <p><em>Тип оголошення: {{$post->post_type ? 'Пропозиція' : 'Потреба'}}</em></p>
                                <p>{{Illuminate\Support\Str::limit($post->description, 200)}}</p>
                                    <a class="btn btn-primary mb-2" href="{{ route('show-post', $post->id) }}">Відкрити повну інформацію</a>
                                @if($post->status === \App\Post::STATUS_ACTIVE)
                                    <a class="btn btn-secondary mb-2" href="{{ route('edit-post', $post->id) }}">Редагувати оголошення</a>
                                    <a class="btn btn-danger mb-2" href="{{ route('inactive-post', $post->id) }}">Деактивувати оголошення</a>
                                    <a class="btn btn-success mb-2" href="{{ route('success-post', $post->id) }}">Оголошення успішне</a>
                                @elseif($post->status === \App\Post::STATUS_INACTIVE)
                                    <a class="btn btn-info mb-2" href="{{ route('active-post', $post->id) }}" style="color: white">Активувати оголошення</a>
                                    <a class="btn btn-success mb-2" href="{{ route('success-post', $post->id) }}">Оголошення успішне</a>
                                @elseif($post->status === \App\Post::STATUS_SUCCESS)
                                    <a class="btn btn-info mb-2" href="{{ route('active-post', $post->id) }}" style="color: white">Активувати оголошення</a>
                                    <a class="btn btn-danger mb-2" href="{{ route('inactive-post', $post->id) }}">Деактивувати оголошення</a>
                                @endif

                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Відсутні оголошення</p>
                @endif
            </div>
        </div>
    </div>
@endsection

