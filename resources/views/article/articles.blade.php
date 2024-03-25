@extends('layout.theme')

@section("post")

<a href="/article/create">Add New Article</a>
@foreach($articles as $article)





<ul class="style1">
    <li class="first">
        <a href="/article/{{$article->id}}"><h3>{{$article->title}}</h3>
        </a>
        <p>{{$article->discription}}</p>
        <a href="/article/{{$article->id}}/edit"><button class='btn btn-primary'>edit</button> </a>
    </li>
    
</ul>

@endforeach

@endsection