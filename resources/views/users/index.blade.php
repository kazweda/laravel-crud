@extends('layouts.app')

@section('title', 'ユーザー一覧')

@section('content')
    <h1 class="text-2xl font-bold mb-4">ユーザー一覧</h1>

    <!-- ユーザー登録ページへのリンク -->
    <a href="{{ route('users.create') }}"
        class="mb-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        ユーザー登録
    </a>

    <!-- セッションメッセージ -->
    @if (session('message'))
        <div><strong>{{ session('message') }}</strong></div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">名前</th>
                    <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                    <th class="px-6 py-3 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if (isset($users))
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-2 whitespace-nowrap">{{ $user->id }}</td>
                            <td class="px-6 py-2 whitespace-nowrap"><a href="{{ route('users.show', $user->id) }}"
                                    class="text-blue-500 hover:underline">{{ $user->name }}</a></td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900">編集</a>
                                @can('admin', $authUser)
                                <td class="px-6 py-2 whitespace-nowrap">
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-20"
                                            onclick="return confirm('本当に削除しますか？')">削除</button>
                                    </form>
                                </td>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- ページネーションリンク -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
