@extends('layouts.app')

@section('content')
    <section style="background-color: #eee;">
      <div class="container my-5 py-5">
        <div class="row d-flex justify-content-center">
          <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card">
              <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                <div class="d-flex flex-start w-100">
                  <img class="rounded-circle shadow-1-strong me-3"
                    src="https://pbs.twimg.com/media/Eo6vnl5U0AATo4J.jpg" alt="avatar" width="40"
                    height="40" />
                  <div data-mdb-input-init class="form-outline w-100">
                    <form action="{{ url('/posts') }}" method="POST">
                        @csrf
                        <textarea class="form-control" name="content" id="textAreaExample" rows="4"
                          style="background: #fff;"></textarea>
                        <label class="form-label" for="textAreaExample">Create a new post:</label>
                        <div class="float-end mt-2 pt-1">
                          <button type="submit" class="btn btn-primary btn-sm">Post</button>
                          <button type="button" class="btn btn-outline-primary btn-sm">Cancel</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row d-flex justify-content-center">
          <div class="col-md-12 col-lg-10 col-xl-8">
            <h2 class="mt-5">Forum :</h2>
            @foreach ($posts as $post)
            @if ($post->level == 0)
              <div class="card mb-3">
                <div class="card-body">
                  <p>{{ $post->content }}</p>
                  <p>By: {{ $post->user->name }} at {{ $post->created_at }}</p>
                  <form action="{{ url('/posts/' . $post->id . '/comment') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <textarea name="content" class="form-control mb-3" rows="1" placeholder="Add a comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-sm mb-3">Comment</button>
                  </form>

                  <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <form action="{{ url('/posts/' . $post->id . '/like') }}" method="POST">
                                @csrf
                    
                                <button type="submit" class="btn btn-success">{{ $post->like }} Like</button>
                            </form>
                        </div>
                         <div class="col-6">
                            <form action="{{ url('/posts/' . $post->id . '/share') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm mb-3">Share</button>
                            </form>
                        </div>
                    </div>
                  </div>
                  
                  
                  @foreach ($post->comments as $comment)
                    <div class="card mt-3 ms-5">
                      <div class="card-body">
                        <p>{{ $comment->content }}</p>
                        <p>By: {{ $comment->user->name }} at {{ $comment->created_at }}</p>
                        <form action="{{ url('/comments/' . $comment->id . '/reply') }}" method="POST">
                          @csrf
                          <div class="form-group mb-2">
                            <textarea name="content" class="form-control" rows="1" placeholder="Reply to this comment"></textarea>
                          </div>
                          <button type="submit" class="btn btn-secondary btn-sm">Reply</button>
                        </form>
                      </div>
                    </div>

                    @foreach ($post->comments as $comment)
                    @if ($post->level == 2)
                    <div class="card mt-3 ms-5">
                      <div class="card-body">
                        <p>{{ $comment->content }}</p>
                        <p>By: {{ $comment->user->name }} at {{ $comment->created_at }}</p>
                        <form action="{{ url('/comments/' . $comment->id . '/reply') }}" method="POST">
                          @csrf
                          <div class="form-group mb-2">
                            <textarea name="content" class="form-control" rows="1" placeholder="Reply to this comment"></textarea>
                          </div>
                          <button type="submit" class="btn btn-secondary btn-sm">Reply</button>
                        </form>
                      </div>
                    </div>
                    @endif
                    @endforeach
                  @endforeach
                </div>
              </div>
            @endif
            @endforeach
          </div>
        </div>
      </div>
    </section>
@endsection

@guest
    <section style="background-color: #eee;">
      <div class="container my-5 py-5">
        <div class="row d-flex justify-content-center">
          <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card">
              <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                <p>Please <a href="{{ route('login') }}">login</a> to create posts and comments.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endguest

