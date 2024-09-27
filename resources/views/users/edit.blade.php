@extends('layouts.app')

@section('title', 'ユーザー情報編集')

@section('content')
    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <h1 class='text-center font-bold '>ユーザー情報編集（変更する箇所のみ入力してください）</h1>

            <!-- 名前フィールド -->
            <div class="mt-4">
                <label for="name">名前</label>
                <input id="name" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="name" value="{{ old('name', $user->name) }}" required placeholder="">
                @error('name')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <!-- メールアドレスフィールド -->
            <div class="mt-4">
                <label for="email">メールアドレス</label>
                <input id="email" type="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="email" value="{{ old('email', $user->email) }}" required placeholder="">
                @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <!-- パスワードフィールド -->
            <div class="mt-4">
                <label for="password">新しいパスワード</label>
                <input id="password" type="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="password" placeholder="">
                @error('password')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <!-- パスワード確認フィールド -->
            <div class="mt-4">
                <label for="password_confirmation">新しいパスワード確認</label>
                <input id="password_confirmation" type="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    name="password_confirmation" placeholder="">
            </div>

            <!-- 画像アップロードフィールド -->
            <div class="mt-4">
                <label for="image">ユーザーアイコン（jpg / png の形式のみで1MB以内）</label>
                <input id="image" type="file" class="block" name="image" accept="image/png,image/jpeg">
                @error('image')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <!-- 現在のアイコン表示 -->
                @if ($user->image)
                    <p>現在のアイコン</p>
                    <img src="{{ asset('storage/images/' . $user->image) }}" alt="現在のアイコン" class="mx-auto h-[300px]">
                @endif
            </div>

            <!-- 管理者権限フィールド -->
            <div class="mt-4">
                <label for="is_admin">管理者権限</label>
                @if ($user->is_admin == '1')
                    <p>現在は権限あり</p>
                @else
                    <p>現在は権限なし</p>
                @endif
                <div>
                    <input type="radio" id="admin_yes" name="is_admin" value="1"
                        {{ $user->is_admin == '1' ? 'checked' : '' }}>
                    <label for="admin_yes">あり</label>

                    <input type="radio" id="admin_no" name="is_admin" value="0"
                        {{ $user->is_admin != '1' ? 'checked' : '' }}>
                    <label for="admin_no">なし</label>
                </div>
            </div>

            <!-- セッションメッセージ -->
            @if (session('message'))
                <div><strong>{{ session('message') }}</strong></div>
            @endif

            <!-- ユーザー情報の表示 -->
            @if (session('user'))
                <div>
                    <strong>ユーザー情報が更新されました。</strong>
                    <h2>更新したユーザーの情報</h2>
                    <p>名前: {{ session('user')->name }}</p>
                    <p>メールアドレス: {{ session('user')->email }}</p>
                    @if (session('passwordChanged'))
                        <p>パスワード: ********</p>
                    @endif
                    @if (session('user')->is_admin === '1')
                        <p>管理者権限: あり</p>
                    @else
                        <p>管理者権限: なし</p>
                    @endif

                    @if (session('user')->image)
                        @if ($user->image)
                            <img src="{{ asset('storage/images/' . $user->image) }}" alt="現在のアイコン"
                                class="mx-auto h-[300px]">
                        @endif
                    @endif
                </div>
            @endif

            <!-- 更新ボタン -->
            <div class="flex items-center justify-center my-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    更新を完了する
                </button>
            </div>

            <div class="mt-4">
                <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">ユーザー一覧に戻る</a>
            </div>
        </div>
    </form>
@endsection
