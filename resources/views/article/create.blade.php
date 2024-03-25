@extends('layout.theme')

@section('post')

<form action="/submitform" method="post">
    <div class="form-group">
        @csrf
        <label for="exampleInputEmail1">Title</label>
        <input type="text" class="form-control" id="title" name="title"aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Discription</label>
<textarea name="discription" class="form-control" id="discription" cols="30" rows="10">
    </textarea>    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>


@endsection