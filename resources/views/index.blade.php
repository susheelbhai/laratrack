<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laratrack</title>
</head>
<body>
    <div class="container">
        @if (Session::has('success'))
            {{ Session::get('success') }}
        @endif
        @if (Session::has('error'))
            {{ Session::get('error') }}
        @endif
        @if (Session::has('request'))
            @php
                $request = Session::get('request');
            @endphp

            @else
            @php
                $request = [];
            @endphp
        @endif
        <div class="row">
            <div class="col">
                <form action="{{ route('laratrack.command') }}" method="post">
                    @csrf
                    
                    <input type="text" name="user_id" placeholder="user ID" value="{{ old('user_id', ($request['user_id'] ?? '')) }}">
                    <input type="text" name="password" placeholder="Password" value="{{ old('password',  ($request['password'] ?? '')) }}">
                    <input type="text" name="command" placeholder="command" value="{{ old('command', ($request['command'] ?? '')) }}">
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('laratrack.dumpAllModel') }}" method="post">
                    @csrf
                    
                    <input type="text" name="user_id" placeholder="user ID" value="{{ old('user_id', ($request['user_id'] ?? '')) }}">
                    <input type="text" name="password" placeholder="Password" value="{{ old('password',  ($request['password'] ?? '')) }}">
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('laratrack.exportModel') }}" method="post">
                    @csrf
                    
                    <input type="text" name="user_id" placeholder="user ID" value="{{ old('user_id', ($request['user_id'] ?? '')) }}">
                    <input type="text" name="password" placeholder="Password" value="{{ old('password',  ($request['password'] ?? '')) }}">
                    <input type="text" name="model" placeholder="model" value="{{ old('model', ($request['model'] ?? '')) }}">
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('laratrack.dumpModel') }}" method="post">
                    @csrf
                    
                    <input type="text" name="user_id" placeholder="user ID" value="{{ old('user_id', ($request['user_id'] ?? '')) }}">
                    <input type="text" name="password" placeholder="Password" value="{{ old('password',  ($request['password'] ?? '')) }}">
                    <input type="text" name="model" placeholder="model" value="{{ old('model', ($request['model'] ?? '')) }}">
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>