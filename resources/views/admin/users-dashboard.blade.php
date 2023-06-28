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
                <h2>Адмін панель користувачів</h2>
                <hr/>
                <form class="mt-3 mb-3" method="GET" action="{{ route('users-dashboard') }}">
                    <h5>
                        Фільтри
                    </h5>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label>Роль користувача</label>
                            <select name="user_role" class="form-select">
                                <option value="" @if ($userRoleFilter === "") {{ 'selected' }} @endif>Виберіть роль користувача</option>
                                <option value="{{\App\User::ROLE_USER}}" @if ($userRoleFilter === \App\User::ROLE_USER) {{ 'selected' }} @endif>Користувач</option>
                                <option value="{{\App\User::ROLE_ADMIN}}" @if ($userRoleFilter === \App\User::ROLE_ADMIN) {{ 'selected' }} @endif>Адмін</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" class="mt-3 btn btn-secondary" value="Відфільтрувати">
                </form>
                @if(count($users))
                    @foreach($users as $user)
                        <div class="card mb-3">
                            <div class="card-header"><strong>{{$user->name.' '.$user->surname}}</strong></div>
                            <div class="card-body">
                                <p>Роль користувача: {{$user->role ? 'Адмін' : 'Користувач'}}</p>
                                <p>Місто: {{$user->city}}</p>
                                <a class="btn btn-primary mb-2" href="{{ route('show-profile', $user->id) }}">Відкрити повну інформацію</a>
                                <a class="btn btn-secondary mb-2" href="{{ route('edit-profile', $user->id) }}">Редагувати профіль</a>
                                @if($user->role === \App\User::ROLE_USER)
                                    <a class="btn btn-success mb-2" href="{{ route('set-admin-role', $user->id) }}">Встановити роль Адмін</a>
                                @elseif($user->role === \App\User::ROLE_ADMIN)
                                    <a class="btn btn-success mb-2" href="{{ route('set-user-role', $user->id) }}">Встановити роль Користувач</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Користувачі відсутні</p>
                @endif
            </div>
        </div>
    </div>
@endsection

