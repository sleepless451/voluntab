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
                <div style="display: flex; justify-content: space-between; align-items: center">
                    <h2>Адмін панель тегів</h2>
                    <a class="btn btn-success" href="{{ route('create-tag') }}">Створити тег</a>
                </div>
                <hr/>
                @if(count($tags))
                    @foreach($tags as $tag)
                        <div class="card mb-3">
                            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center">
                                <strong>{{$tag->name}}</strong>
                                <div>
                                    <a class="btn btn-secondary" href="{{ route('edit-tag', $tag->id) }}">Редагувати тег</a>
                                    <a class="btn btn-danger" href="{{ route('delete-tag', $tag->id) }}">Видалити тег</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Відсутні теги</p>
                @endif
            </div>
        </div>
    </div>
@endsection

