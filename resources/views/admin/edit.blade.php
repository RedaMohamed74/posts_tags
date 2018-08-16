@extends('admin.index')
@section('content')

<div class="row list-group-item-info page-title">

	<div class="col-xs-12">
		EDIT POST ..
	</div>
</div>	
	
<div class="row list-group-item-info">
	<form method="POST" action="update">
	{{ csrf_field() }}
	<div class="input-group">
		<input type="text" name="body" value="{{$post->body}}" class="form-control" placeholder="add Note . . .">
		<span class="input-group-btn">
			<button class="btn btn-primary" type="submit">Edit</button>
			<a href="#" class="btn btn-danger">cancel</a>
		</span>
	</div>	
	</form>
</div>
	
@stop