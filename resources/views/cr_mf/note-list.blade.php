<ul class="nav nav-pills flex-column">
    @foreach($crNoteData as $note)
        <li class="nav-item">
            <a href="#" class="nav-link note_list_btn" data-note_id="{{$note->id}}">
                <i class="far fa-envelope"></i> &nbsp; {{\Carbon\Carbon::parse($note->note_date)->format('d M Y')}}
                <span class="badge bg-primary float-right">{{$note->note_type}}</span>
            </a>
        </li>
    @endforeach
</ul>
