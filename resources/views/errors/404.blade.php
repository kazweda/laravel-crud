@extends('layouts.app')

@section('title', 'ページが見つかりません')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-center font-bold text-2xl mb-4">ページが見つかりません。</h1>
        <p class="text-center">申し訳ありませんが、お探しのページが見つかりませんでした。</p>
        <div class="flex justify-center mt-6">
            <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">ユーザー一覧に戻る</a>
        </div>
    </div>
@endsection