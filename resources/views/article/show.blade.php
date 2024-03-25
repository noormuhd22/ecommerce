@extends("layout.theme")
@section("post")


<a href="/article">View All articles</a>
<h2>{{$article->title}}</h2>
<p>{{$article->discription}}</p>



@endsection