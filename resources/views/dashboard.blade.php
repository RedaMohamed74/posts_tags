@extends('layouts.master')

@section('content')
    @include('include.message_block')
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What do you have to say?</h3></header>
            <form action="{{ route('post.create') }}" method="post" role="form" class="new-edit-11" enctype="multipart/form-data">
                <div class="form-group">
                    <textarea class="form-control" name="body" id="new-post" rows="5" placeholder="Your Post"></textarea>
                    <!-- this form to enter img to your post -->
                <div class="tab-pane" id="extra"  style=" margin: 7px;">
                    <a href="" class="btn btn-primary">To enter another image click here..</a>

                <div class="images-upload-block" style=" margin: 7px;">
                   <label for="Experience0ExperienceContent">
                        <input  name="1" id="Experience0ExperienceContent" type="file">
                   </label>
                </div>
                </div>
                    <!-- this form to enter img to your post -->
                </div>
                                <button type="submit" class="btn btn-primary">Create Post ...</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
        </div>

            </form>
    </section>
    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What other people say...</h3></header>
            @foreach($posts as $post)
                <article class="post" data-postid="{{ $post->id }}">
                    <form action="{{route('search')}}" method="get"> 
                    <p>@php
                        echo $post->body;
                    @endphp </p>
{{--                     <a href="{{route('search')}}">pppP</a>
 --}}                    </form>
                    @foreach($images as $image)
                    @if($image->post_id==$post->id)
                      <img src="{{URL::to('storage/images/'.$image->name)}}" width="90" height="90">
                    @endif
                    @endforeach
                    <div class="info">
                        Posted by {{ $post->user->first_name }} on {{ $post->created_at }}
                    </div>
                    <div class="interaction">
                        <a href="#" class="Tag">{{ Auth::user()->tags()->where('post_id', $post->id)->first() ? Auth::user()->tags()->where('post_id', $post->id)->first()->tag == 1 ? 'You tags this post' : 'Tag':'Tag' }}</a> 
                        @if(Auth::user() == $post->user)
                            |
                            <a href="" class="edit">Edit</a> |
                            <a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Post</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="post-body">Edit the Post</label>
                            <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        var token = '{{ Session::token() }}';
        var urlEdit = '{{ route('edit') }}';
        var urlTag = '{{ route('Tag') }}';
    </script>

    <!-- jQuery 3  and script for add input-->
    <script src="{{ url('design/adminlte') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
            $("#extra a").click(function() {   
            var $div = $(this).next();
            $div.find("input")
                .last()
                .clone()
                .appendTo($div.append("<br/>"))
                .val("")
                .attr("name",function(i,oldVal) {
                    return oldVal.replace(/\d+/,function(m){
                        return (+m + 1);
                    });
                });
            return false;
        });
    </script>
    <!-- jQuery 3  and script for add input-->

@endsection