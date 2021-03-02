<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.08.2016
 * Time: 14:41
 */

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles= Article::where('status','PUBLISHED')->orderBy('date', 'desc')->paginate(3);

        return view('Allnews',compact('articles'));
    }

    public function getNews($id)
    {

        $articles= Article::find($id);
        if($articles == NULL){
            App::abort(404);
        }

//        return view('news',compact('news'));
        return View('news',array('title'=>$articles['title'],'news'=>$articles));
    }

}