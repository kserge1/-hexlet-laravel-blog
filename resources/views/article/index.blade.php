@extends('layouts.app')

@section('flash')
@if (session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif
@endsection

@section('content')
    <h1>Список статей</h1>
    <div><a href="{{route('articles.create')}}">Новая статья</a></div>
    @foreach ($articles as $article)
        <h2><a href="{{route('articles.show', [$article])}}">{{$article->name}}</a></h2>
        {{-- Str::limit – функция-хелпер, которая обрезает текст до указанной длины --}}
        {{-- Используется для очень длинных текстов, которые нужно сократить --}}
        <div>{{Str::limit($article->body, 200)}}</div>
        <span><a href="{{route('articles.edit', [$article])}}">Редактировать</a></span>
        <span><a href="{{route('articles.destroy', [$article])}}" data-confirm="Вы уверены?" data-method="delete" rel="nofollow">Удалить</a></span>
    @endforeach
@endsection

@section('paginator')
{{ $articles->links() }}
@endsection
