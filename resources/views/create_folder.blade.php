@extends('layouts.main')

@section('content')

<div class="content_main">
    <div class="search_block">
        <form action="{{route('folder.create')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="custom-file">
                <input type="text" name="folder_name" class="custom-file-input" placeholder="введите название новой папки" value="" required>
                <button type="submit" class="search_button"><i class="fas fa-plus-circle"></i></button>
            </div>
        </form>
    </div>
    @if ($message = Session::get('message'))
        <div class="notify_block">
        <strong>{{ $message }}</strong>
        </div>
    @endif
</div>

@endsection
