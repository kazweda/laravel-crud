@extends('layouts.app')

@section('title', '新規作成')

@section('content')
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div>
            <h1 class='text-center font-bold '>新規作成</h1>
            <div class="mt-4">
                <label for="name">名前</label>
                <input id="name" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mt-4">
                <label for="email">メールアドレス</label>
                <input id="email" type="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mt-4">
                <label for="password">パスワード</label>
                <input id="password" type="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="password" value="{{ old('password') }}" required>
            </div>

            @if (session('message'))
                <div>{{ session('message') }}</div>
            @endif

            @isset($user)
                <div>
                    <strong>ユーザー登録が完了しました。</strong>
                    <h2>登録したユーザーの情報</h2>
                    <p>名前: {{ $user->name }}</p>
                    <p>メールアドレス: {{ $user->email }}</p>
                    <p>パスワード: ********</p>
                </div>
            @endisset

            <div class="flex items-center justify-center my-4">
                <button type="submit">
                    登録を完了する
                </button>
            </div>
    </form>
@endsection