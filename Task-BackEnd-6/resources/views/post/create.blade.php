<x-layout>
    <x-header />
    <div class="container ">
        <div class="row">
            <div class="col-md-8 offset-md-2 ">
                <div class="card bg-transparent">
                    <div class="card-header text-white border-white">Create Post</div>
                    <div class="card-body">
                        <form action="{{ route('post.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text"
                                    class="form-control border-primary-subtle text-white bg-transparent" id="title"
                                    name="title" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control border-primary-subtle text-white bg-transparent" id="content" name="content"
                                    rows="5" placeholder="Enter content"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
