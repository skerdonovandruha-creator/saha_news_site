@extends('layouts.main')

@section('title', 'Админ — пользователи')

@section('content')
    <h1 class="page-head">Админ: пользователи</h1>

    <p class="text-muted">
        <a href="{{ route('admin.articles') }}">← Назад к статьям</a>
    </p>

    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Логин</th>
                <th>Сейчас роль</th>
                <th>Статей</th>
                <th>Сменить роль</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->login }}</td>
                    <td><span class="badge text-bg-secondary">{{ $user->role->name }}</span></td>
                    <td>{{ $user->texts_count }}</td>
                    <td>
                        {{-- смена роли --}}
                        <form method="POST" action="{{ route('admin.user.role', $user) }}"
                              class="d-flex gap-2">
                            @csrf
                            @method('PUT')
                            <select name="role_id" class="form-select form-select-sm">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Применить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
