<x-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 ">
                <div class="card bg-transparent text-white">
                    <div class="card-header border-white">Edit Post</div>
                    <div class="card-body ">
                        <form action="{{ route('post.update', $post) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control bg-transparent text-white" name="title"
                                    value="{{ old('title', $post->title) }}" placeholder="Enter title">
                            </div>
                            <div class="form-group ">
                                <label for="content">Content</label>
                                <textarea class="form-control bg-transparent text-white" name="content" rows="5" placeholder="Enter content">{{ old('content', $post->content) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 ">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
