@extends('layouts.app')

@section('content')
    <h1>Welcome to Social App</h1>

    @auth
        <form action="{{ url('/posts') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">Create a new post:</label>
                <textarea name="content" id="content" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
        </form>

        <h2>Posts</h2>
        @foreach ($posts as $post)
            <div class="post">
                <p>{{ $post->content }}</p>
                <p>By: {{ $post->user->username }} at {{ $post->created_at }}</p>
                <form action="{{ url('/posts/' . $post->id . '/comment') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" rows="1" placeholder="Add a comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary">Comment</button>
                </form>
                <form action="{{ url('/posts/' . $post->id . '/like') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Like</button>
                </form>
                <form action="{{ url('/posts/' . $post->id . '/share') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-info">Share</button>
                </form>
                @foreach ($post->comments as $comment)
                    <div class="comment">
                        <p>{{ $comment->content }}</p>
                        <p>By: {{ $comment->user->username }} at {{ $comment->created_at }}</p>
                        <form action="{{ url('/comments/' . $comment->id . '/reply') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="1" placeholder="Reply to this comment"></textarea>
                            </div>
                            <button type="submit" class="btn btn-secondary">Reply</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endauth

    @guest
        <p>Please <a href="{{ route('login') }}">login</a> to create posts and comments.</p>
    @endguest
@endsection
