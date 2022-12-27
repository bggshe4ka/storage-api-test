@extends('layouts.main')

@section('content')

<div class="content_main">
        <div class="search_block">
            

            <h3 class="text-center mb-5">Старое название: {{$file_to_edit->name}}</h3>
            <form action="/update/{{$file_to_edit->id}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="custom-file">
                <input type="text" name="file_name" class="custom-file-input" placeholder="Введите новое" value="" required>
                <button type="submit" class="search_button"><i class="fas fa-save"></i></button>
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
