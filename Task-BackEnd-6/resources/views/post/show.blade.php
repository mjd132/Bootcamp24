<x-layout><x-header />
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 ">
                <div class="card bg-transparent text-white">
                    <div class="card-header border-white">
                        <h5 class="card-title ">{{ $post->title }}</h5>
                    </div>
                    <div class="card-body ">
                        <p class="card-text">{{ $post->content }}</p>
                    </div>
                    <div class="card-footer text-white border-white">
                        <small>Created: {{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>

            </div>
            @auth
                <div class="col-md-2">
                    <a href="{{ route('post.edit', $post) }}" class="btn btn-outline-warning mb-1"><i
                            class="bi bi-pencil-fill"></i></a>
                    <form action="{{ route('post.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit"><i class="bi bi-trash-fill "></i></button>
                    </form>
                </div>
            @endauth

        </div>
    </div>
</x-layout>
