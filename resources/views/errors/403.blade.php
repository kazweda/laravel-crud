@extends('layouts.app')

@section('title', '権限がありません。')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-center font-bold text-2xl mb-4">権限がありません。</h1>
        <p class="text-center">管理者にお問い合わせください。</p>
        <div class="flex justify-center mt-6">
            <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">ユーザー一覧に戻る</a>
        </div>
    </div>
@endsection