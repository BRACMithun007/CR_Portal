<ul class="nav nav-pills flex-column">
    @foreach($crCommentData as $comment)
        <li class="nav-item">
            <a href="#" class="nav-link comment_list_btn" data-comment_id="{{$comment->id}}">
                <i class="far fa-envelope"></i> &nbsp; {{\Carbon\Carbon::parse($comment->comment_date)->format('d M Y')}}
{{--                <span class="badge bg-primary float-right">{{$comment->note_type}}</span>--}}
            </a>
        </li>
    @endforeach
</ul>
