<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}






<form action="{{route('file.upload')}}" method="post" enctype="multipart/form-data">
          <h3 class="text-center mb-5">Upload File in Laravel</h3>
            @csrf
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
          @endif
          @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="chooseFile">
                <label class="custom-file-label" for="chooseFile">Select file</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                Upload Files
            </button>
        </form>

        @foreach($user_files as $file)
        	{{$file->path}} <br>
        @endforeach
        TOTAL : {{$sizee}}

<form action="/update/2" method="post" enctype="multipart/form-data">
	@csrf
	<input type="text" name="name" class="custom-file-input" id="name" value="test123123">
	<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
              Test
           </button>
</form>

<form action="/remove/2" method="get" enctype="multipart/form-data">
	@csrf
	<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
              del
           </button>
</form>


<form action="/create-folder" method="post" enctype="multipart/form-data">
	@csrf
	<input type="text" name="name" class="custom-file-input" id="name" value="test123123">
	<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
              Test
           </button>
</form>









                </div>
            </div>
        </div>
    </div>
</x-app-layout>
