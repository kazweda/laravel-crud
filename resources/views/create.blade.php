@extends('layouts.app')

@section('title', '新規作成')

@section('content')
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div>
            <h1 class='text-center font-bold '>新規作成</h1>
            <div class="mt-4">
                <label for="name">名前</label>
                <input id="name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div>{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-center my-4">
                <button type="submit">
                    登録を完了する
                </button>
            </div>
    </form>
@endsection