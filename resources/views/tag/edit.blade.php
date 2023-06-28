@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="content">
            <form method="POST" action="{{ route('update-tag', $tag->id) }}" aria-label="Edit Tag">
                @csrf
                <div>
                    <div>
                        <h2 class="box-title">Сторінка редагування тегу</h2>
                        @include('layouts.errors')
                    </div>
                    <hr/>
                    <div>
                        <div class="form-group">
                            <label>Назва</label>
                            <input type="text" class="form-control" name="name" placeholder="" value="{{old('name', $tag->name)}}">
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-success pull-right">Зберегти тег</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
