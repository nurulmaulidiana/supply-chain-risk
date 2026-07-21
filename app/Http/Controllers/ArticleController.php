<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    // tampil daftar artikel
    public function index()
    {
        $articles = Article::latest()->get();

        return view('admin.articles.index', compact('articles'));
    }


    // form tambah artikel
    public function create()
    {
        return view('admin.articles.create');
    }


    // simpan artikel
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'nullable'
        ]);


        Article::create([

            'title' => $request->title,

            'content' => $request->content,

            'category' => $request->category

        ]);


        return redirect()
            ->route('articles.index')
            ->with('success','Artikel berhasil ditambahkan');

    }


    // form edit
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('admin.articles.edit', compact('article'));
    }


    // update artikel
    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);


        $article = Article::findOrFail($id);


        $article->update([

            'title'=>$request->title,

            'content'=>$request->content,

            'category'=>$request->category

        ]);


        return redirect()
            ->route('articles.index')
            ->with('success','Artikel berhasil diubah');

    }


    // hapus artikel
    public function destroy($id)
    {

        Article::findOrFail($id)->delete();


        return redirect()
            ->route('articles.index')
            ->with('success','Artikel berhasil dihapus');

    }

}