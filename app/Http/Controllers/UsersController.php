<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create'); // ここで 'create.blade.php' ビューを返します
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            // トランザクションを開始
            DB::beginTransaction();

            // $userインスタンスを作成する
            $user = new User();

            // 投稿フォームから送信されたデータを取得し、インスタンスの属性に代入する
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');

            // データベースに保存
            $user->save();

            // トランザクションをコミット
            DB::commit();

            return view('users.create', compact('user'))->with('message', '登録が完了しました！');
        } catch (Exception $e) {
            // トランザクションをロールバック
            DB::rollBack();

            return back()->with('message', '登録に失敗しました。' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $passwordChanged = false; // パスワードが変更されたかどうかのフラグ

        // パスワードが入力されている場合のみ更新
        if (!empty($data['password'])) {
            $passwordChanged = true;
        } else {
            unset($data['password']); // パスワードフィールドをデータ配列から削除
        }

        DB::beginTransaction();

        try {
            $user->update($data);

            DB::commit();

            return
                redirect()->route('users.edit', $user->id)->with(compact('user', 'passwordChanged'));;
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with(['message' => '更新中にエラーが発生しました。' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('message', 'ユーザーが削除されました');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('message', 'ユーザーの削除中にエラーが発生しました: ' . $e->getMessage());
        }
    }
}
