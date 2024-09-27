<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authUser = auth()->user();
        if (Gate::allows('admin', $authUser)) {
            $users = User::paginate(5); // 管理者はすべてのユーザーを5件ごとに表示
        } else {
            $users = User::where('id', $authUser->id)->get();; // 管理者でない場合は自分の情報のみ表示なのでページングは不要
        }
        return view('users.index', compact('users', 'authUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('admin');
        return view('users.create'); // ここで 'create.blade.php' ビューを返します
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        Gate::authorize('admin');
        DB::beginTransaction();
        try {
            $user = new User();

            // 投稿フォームから送信されたデータを取得し、インスタンスの属性に代入する
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->is_admin = $request->input('is_admin', '0');

            $user->save();

            // 画像がアップロードされているか確認し、保存
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = date('Ymd_His') . '_user_id_' . $user->id . '.' . $file->getClientOriginalExtension(); // タイムスタンプをファイル名に使用
                $file->storeAs('public/images', $filename); // imagesディレクトリにファイルを保存
                $user->image = $filename;
                $user->save();
            }

            DB::commit();

            return view('users.create', compact('user'))->with('message', '登録が完了しました！');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('message', '登録に失敗しました。' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $authUser = auth()->user();
        if (Gate::allows('admin', $authUser) || auth()->user()->id === $user->id) {
            return view('users.show', compact('user'));
        }

        // それ以外の場合は403権限なしを表示する
        abort(403, 'Forbidden');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('edit_update', [auth()->user(), $user]);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('edit_update', [auth()->user(), $user]);
        $data = $request->validated();

        $passwordChanged = false; // パスワードが変更されたかどうかのフラグ

        // パスワードが入力されている場合のみ更新
        if (!empty($data['password'])) {
            $passwordChanged = true;
        } else {
            unset($data['password']); // パスワードフィールドをデータ配列から削除
        }

        // 画像を更新する前に旧画像のファイル名を保持
        $oldImage = $user->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('Ymd_His') . '_user_id_' . $user->id . '.' . $file->getClientOriginalExtension(); // タイムスタンプをファイル名に使用
            $file->storeAs('public/images', $filename); // imagesディレクトリにファイルを保存
            $data['image'] = $filename; // DBにはファイル名のみを保存
        }

        DB::beginTransaction();

        try {
            $user->update($data);
            
            // 新しい画像がアップロードされていれば、古い画像を削除
            if ($request->hasFile('image') && $oldImage) {
                Storage::disk('public')->delete('images/' . $oldImage);
            }

            DB::commit();

            return
                redirect()->route('users.edit', $user->id)->with(compact('user', 'passwordChanged'));
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
        Gate::authorize('admin');
        DB::beginTransaction();
        try {
            $oldImage = $user->image;

            $user->delete();

            // 画像が存在する場合、削除する
            if ($oldImage && Storage::disk('local')->exists('public/images/' . $oldImage)) {
                Storage::disk('local')->delete('public/images/' . $oldImage);
            }

            DB::commit();
            
            return redirect()->route('users.index')->with('message', 'ユーザーが削除されました');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('message', 'ユーザーの削除中にエラーが発生しました: ' . $e->getMessage());
        }
    }
}
