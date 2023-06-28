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
                <h2>Мої оголошення</h2>
                <hr/>
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
                                @endif
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
