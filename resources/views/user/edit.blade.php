@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="content">
            <form method="POST" action="{{ route('update-profile', $user->id) }}" aria-label="Edit Profile">
                @csrf
                <div>
                    <div>
                        <h2 class="box-title">Сторінка редагування профілю</h2>
                    </div>
                    <hr/>
                    <div>
                        <div class="form-group">
                            <label>Ім'я:</label>
                            <input type="text" class="form-control" name="name" placeholder="" value="{{old('name', $user->name)}}">
                        </div>
                        <div class="form-group">
                            <label>Призвіще:</label>
                            <input type="text" class="form-control" name="surname" placeholder="" value="{{old('surname', $user->surname)}}">
                        </div>
                        <div class="form-group">
                            <label>Місто:</label>
                            <input type="text" class="form-control" name="city" placeholder="" value="{{old('city', $user->city)}}">
                        </div>
                        <div class="form-group">
                            <label>Електронна пошта:</label>
                            <input type="email" class="form-control" name="email" placeholder="" value="{{old('email', $user->email)}}">
                        </div>
                        <div class="form-group">
                            <label>Новий пароль:</label>
                            <input type="password" class="form-control" name="password" placeholder="">
                        </div>
                        <input type="submit" class="btn btn-success" value="Зберегти">
                    </div>
                </div>
            </form>

        </section>
    </div>
@endsection




