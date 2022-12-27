@extends('layouts.main')

@section('content')

<div class="content_main">
    <div class="search_block">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            <form action="{{route('file.upload')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="folders_block">
                @if(!empty($user_folders))
                    <select name="folder_select" id="folder_select">
                        <option value="0">Выберите папку </option>
                        @foreach ($user_folders as $folder)
                            <option value="{{$folder->id}}">{{$folder->name}}</option>
                        @endforeach
                    </select>
                @endif
                ИЛИ
                <a href="{{route('folder.create')}}" class="create_button"> Создайте новую  </a>
            </div>
            
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="chooseFile" hidden="">
                <div class="file_selector"><label class="custom-file-label" for="chooseFile">Выбрать файл</label></div>
                <button type="submit" class="search_button"><i class="fas fa-upload"></i></button>
            </div>
            </form>    
            <label for="file">Ваше облако заполнено на {{$user_cloud_size}}MB из 100MB</label> <br>
            <progress id="file" max="100" value="{{$user_cloud_size}}"></progress>
            <br>Суммарно в облаке файлов: {{$total_cloud_size}} MB  <br>
            @endauth
            @guest
                <p style="font-size: 20pt;"> Для начала работы   </p>
                <a href="{{ route('login') }}" class="logreg_button">Войдите</a>
                ИЛИ 
                <a href="{{ route('register') }}" class="logreg_button">Зарегистрируйтесь</a>
            @endguest

        </div>
    </div>
    @if ($message = Session::get('message'))
        <div class="notify_block">
            <strong>{{ $message }}</strong>
        </div>
    @endif
</div>

@endsection
