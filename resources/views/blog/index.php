<h2>main contain</h2>
@if(isset($posts))
<ul>
    @foreach($posts as $post)
    <li><h2><a href="{{url('post/'.$post->id)}}">{{$post->title}}</a></h2>
        id: {{$post->id}}</li>
    @endforeach
</ul>
@endif