<x-layout>
    <x-header />
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 ">
                <div class="d-flex justify-content-between mb-2">
                    <h3>Posts</h3>
                    @auth
                        <a href="{{ route('post.create') }}" class="btn btn-outline-primary">Create Post</a>
                    @endauth
                </div>
                @if ($posts->isEmpty())
                    <p>No posts found.</p>
                @else
                    <div class="list-group ">

                        @foreach ($posts as $post)
                            <div
                                class="d-flex justify-content-between list-group-item list-group-item-action bg-transparent align-items-center">
                                <a href="{{ route('post.show', $post) }}"
                                    class="text-decoration-none bg-transparent text-white flex-grow-1">

                                    <h5 class="mb-1">{{ $post->title }}</h5>
                                    <p class="mb-1">{{ Str::limit($post->content, 100) }}</p>
                                    <small>{{ $post->created_at->diffForHumans() }}</small>

                                </a>
                                @auth
                                    <div>
                                        <a href="{{ route('post.edit', $post) }}" class="btn btn-outline-warning mb-1"><i
                                                class="bi bi-pencil-fill"></i></a>
                                        <form action="{{ route('post.destroy', $post) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger" type="submit"><i
                                                    class="bi bi-trash-fill "></i></button>
                                        </form>
                                    </div>

                                @endauth


                            </div>
                        @endforeach

                    </div>
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
