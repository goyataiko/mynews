<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        $this->validate($request, Profile::$rules);

        $profile = new Profile;
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $profile->fill($form);
        $profile->save();
        return redirect('admin/profile/');
    }

    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        // profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        // 송신된 폼 데이터를 삽입입
        $profile_form = $request->all();
        
        unset($profile_form['_token']);

        // 該当するデータを上書きして保存する
        $profile->fill($profile_form)->save();

        return redirect('admin/profile');
    }
    
    
    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $posts = Profile::where('title', $cond_title)->get();
        } else {
            $posts = Profile::all();
        }
        return view('admin.profile.index', ['posts' => $posts, 'cond_name' => $cond_name]);
    }
    
    public function delete(Request $request)
    {
        // 該当するprofile Modelを取得
        $profile = Profile::find($request->id);

        // 削除する
        $profile->delete();

        return redirect('admin/profile/');
    }
    
}
