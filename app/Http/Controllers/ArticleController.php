<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Requests\ValidateArticles;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::paginate(3);

        // Статьи передаются в шаблон
        // compact('articles') => [ 'articles' => $articles ]
        return view('article.index', compact('articles'));
    }
    
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('article.show', compact('article'));
    }
    
    // Вывод формы
    public function create()
    {
        // Передаём в шаблон вновь созданный объект. Он нужен для вывода формы через Form::model
        $article = new Article();
        return view('article.create', compact('article'));
    }
    
    // Здесь нам понадобится объект запроса для извлечения данных
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
    
    public function edit($id)
    {
		$article = Article::findOrFail($id);
		return view('article.edit', compact('article'));
    }
    
    //public function update(Request $request, $id)
    public function update(ValidateArticles $request, $id)
    {
		$article = Article::findOrFail($id);
		$validated = $request->validated($article);
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
    
    public function destroy($id)
    {
		// DELETE — идемпотентный метод, поэтому результат операции всегда один и тот же
		$article = Article::find($id);
		if ($article) {
			$article->delete();
		}
		return redirect()->route('articles.index')
		->with('status','Article deleted successfully!');
    }
    
}
