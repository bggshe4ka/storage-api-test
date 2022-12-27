@extends('layouts.main')

@section('content')

<div class="content_main" style="text-align: unset;">
    <div class="files_block">
        <div class="folder_grid" onclick="history.back()";>  <i class="fas fa-backward"></i> <p class="folder_name_str"> Назад </p> </div>
        @foreach($user_files as $file)
            <div class="file_grid"><i class="fas fa-file"></i> <p class="file_name_str"> {{$file->name}}  <p> 
                <div class="todo_files">
                    <a href="/download/{{$file->id}}"><i class="fas fa-download"> </i> </a>
                    <a href="/edit/{{$file->id}}"><i class="fas fa-pencil-alt"></i> </a>
                    <a href="/remove/{{$file->id}}"><i class="fas fa-trash-alt"></i> </a>
                    <a href="/share/{{$file->id}}"><i class="fas fa-share-alt"></i></a>
                </div>
            </div> 
        @endforeach
    </div>
    @if ($message = Session::get('message'))
        <div class="notify_block">
            <strong>{{ $message }}</strong>
        </div>
    @endif
</div>

@endsection
