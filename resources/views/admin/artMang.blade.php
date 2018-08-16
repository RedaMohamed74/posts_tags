@extends('admin.index')
@section('content')


<span><h4>Articles Management ...</h4></span>

<div class="">
{{--     <div class="col-xs-12">
     test test test
    </div> --}}
</div>
@foreach ($posts as $post)
<div class="row list-group-item">
    <div class="col-xs-8">
     @php
         echo $post->body;
     @endphp  
    </div>
    <div class="col-xs-4">
        <a href="{{ aurl() }}/posts/{{$post->id}}/delete" type="button" class="btn btn-danger pull-right" style="margin-bottom:5px; ">Delete</a> 
        <a href="{{ aurl() }}/posts/{{$post->id}}/edit" type="button" class="btn btn-default pull-right" style="margin-bottom:5px; ">Edit</a> 
    </div>
@foreach($images as $image)
   @if($image->post_id==$post->id)
     <img class="pull-right" style="margin:10px; " src="{{URL::to('storage/images/'.$image->name)}}" width="60" height="60">
   @endif
   @endforeach
</div>
@endforeach

@if(count($errors))
  <ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>
  @endif



@endsection