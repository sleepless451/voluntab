@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Результати пошуку</h2>
                <hr/>
                @if(count($posts))
                    @foreach($posts as $post)
                        <div class="card mb-3">
                            <div class="card-header"><strong>{{$post->title}}</strong></div>
                            <div class="card-body">
                                <p><em>Тип оголошення: {{$post->post_type ? 'Пропозиція' : 'Потреба'}}</em></p>
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
