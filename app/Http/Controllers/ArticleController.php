<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateArticles;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $articles = Article::paginate(3);

        // Статьи передаются в шаблон
        // compact('articles') => [ 'articles' => $articles ]
        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Передаём в шаблон вновь созданный объект. Он нужен для вывода формы через Form::model
        $article = new Article();
        return view('article.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Проверка введённых данных
        // Если будут ошибки, то возникнет исключение
        $this->validate($request, [
            'name' => 'required|unique:articles',
            'body' => 'required|min:5',
        ]);

        $article = new Article();
        // Заполнение статьи данными из формы
        $article->fill($request->all());
        // При ошибках сохранения возникнет исключение
        $article->save();

        // Редирект на указанный маршрут с добавлением флеш-сообщения
        return redirect()
            ->route('articles.index')
            ->with('status','Article created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article = Article::findOrFail($article->id);
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $article = Article::findOrFail($article->id);
		return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateArticles $request, Article $article)
    {
        $article = Article::findOrFail($article->id);
		$validated = $request->validated();
		/*$this->validate($request, [
			// У обновления немного изменённая валидация. В проверку уникальности добавляется название поля и id текущего объекта
			// Если этого не сделать, Laravel будет ругаться на то что имя уже существует
			'name' => 'required|unique:articles,name,' . $article->id,
			'body' => 'required|min:5',
		]);
		*/
		$article->fill($request->all());
		$article->save();
		return redirect()
			->route('articles.index')
			->with('status','Article edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        // DELETE — идемпотентный метод, поэтому результат операции всегда один и тот же
		$article = Article::find($article->id);
		if ($article) {
			$article->delete();
		}
		return redirect()->route('articles.index')
		->with('status','Article deleted successfully!');
    }
}
