@extends('layouts.app')

@section('title', 'ユーザー情報')

@section('content')
    <div class="container mx-auto">
        @isset($user)
            <h1 class="text-2xl font-semibold mb-4">{{ $user->name }} さんの情報</h1>
            <table class="min-w-full border-collapse border border-gray-200">
                <tr>
                    <td class="border border-gray-200 px-4 py-2 font-semibold">ユーザーアイコン</td>
                    <td class="border border-gray-200 px-4 py-2">
                        @if ($user->image)
                            @if ($user->image)
                                <img src="{{ asset('storage/images/' . $user->image) }}" alt="現在のアイコン" class="mx-auto h-[300px]">
                            @endif
                        @else
                            ユーザーアイコンは設定されていません。
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="border border-gray-200 px-4 py-2 font-semibold">ID</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $user->id }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-200 px-4 py-2 font-semibold">名前</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-200 px-4 py-2 font-semibold">メールアドレス</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $user->email }}</td>
                </tr>

                <tr>
                    <td class="border border-gray-200 px-4 py-2 font-semibold">管理者権限</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $user->is_admin ? 'はい' : 'いいえ' }}</td>
                </tr>
            </table>
        @endisset

        <div class="mt-4">
            <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">ユーザー一覧に戻る</a>
        </div>
    </div>
@endsection
