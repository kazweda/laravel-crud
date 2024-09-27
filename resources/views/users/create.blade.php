@extends('layouts.app')

@section('title', '新規作成')

@section('content')
    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <h1 class='text-center font-bold '>新規作成</h1>
            <!-- 名前フィールド -->
            <div class="mt-4">
                <label for="name">名前</label>
                <input id="name" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="name" value="{{ old('name') }}" required placeholder="">
                @error('name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <!-- メールアドレスフィールド -->
            <div class="mt-4">
                <label for="email">メールアドレス</label>
                <input id="email" type="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="email" value="{{ old('email') }}" required placeholder="">
                @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <!-- パスワードフィールド -->
            <div class="mt-4">
                <label for="password">パスワード</label>
                <input id="password" type="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="password" required placeholder="">
                @error('password')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <!-- パスワード確認フィールド -->
            <div class="mt-4">
                <label for="password_confirmation">パスワード確認</label>
                <input id="password_confirmation" type="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="password_confirmation" required placeholder="">
            </div>

            <!-- 画像アップロードフィールド -->
            <div class="mt-4">
                <label for="image">ユーザーアイコン（jpg / png の形式のみで1MB以内）</label>
                <input id="image" type="file" class="block" name="image" accept="image/png,image/jpeg">
                @error('image')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <!-- 登録ボタン -->
            <div class="flex items-center justify-center my-4">
                <button type="submit">
                    登録を完了する
                </button>
            </div>

            <!-- セッションメッセージ -->
            @if (session('message'))
                <div><strong>{{ session('message') }}</strong></div>
            @endif

            <!-- ユーザー情報 -->
            @isset($user)
                <strong>ユーザー登録が完了しました。</strong>
                <h2>登録したユーザーの情報</h2>
                <p>名前: {{ $user->name }}</p>
                <p>メールアドレス: {{ $user->email }}</p>
                <p>パスワード: ********</p>
                @if ($user->image)
                    <img src="{{ asset('storage/images/' . $user->image) }}" alt="現在のアイコン" class="mx-auto h-[300px]">
                @endif
            @endisset
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">ユーザー一覧に戻る</a>
        </div>
    </form>
@endsection
