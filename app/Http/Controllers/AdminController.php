<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
	{
		return view("admin.dashboard");
	}

    public function articles()
    {
        $users = User::latest()->get();
        $articles = Article::latest()->get();
        return view('admin.articles', compact('articles'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
    
    public function toggleArticleStatus($id) {
        // SECURE
        // if(!Auth::user()->isAdmin()){
        //     return back()->withMessage("Operation not permitted");
        // }
        
        $article = Article::find($id);
        $article->published = !$article->published;
        $article->save();
        return back();
    }

	public function toggleUsersAdmin($id)
	{
        // SECURE
        // if(!Auth::user()->isAdmin()){
        //     return back()->withMessage("Operation not permitted");
        // }
        // UNSECURE
		$user = User::find($id);
        $user->is_admin = !$user->is_admin;
        $user->save();
        return back();
	}
}