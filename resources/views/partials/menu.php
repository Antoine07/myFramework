<nav>
    <ul>
        @if(isset($categories))
        @foreach($categories as $category)
        <li>{{$category->title}}</li>
        @endforeach
        @endif
    </ul>
</nav>