@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="content">
            <div>
                <div class="mb-3">
                    <h2 class="box-title mb-3">Мій профіль</h2>
                    <a class="btn btn-secondary" href="{{ route('edit-profile', $user->id) }}">Редагувати профіль</a>
                </div>
                <hr/>
                <div>
                    <div class="form-group">
                        <label><strong>Ім'я:</strong></label>
                        <p>{{$user->name}}</p>
                    </div>
                    <div class="form-group">
                        <label><strong>Призвіще:</strong></label>
                        <p>{{$user->surname}}</p>
                    </div>
                    <div class="form-group">
                        <label><strong>Місто:</strong></label>
                        <p>{{$user->city}}</p>
                    </div>
                    <div class="form-group">
                        <label><strong>Електронна пошта:</strong></label>
                        <p>{{$user->email}}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection



