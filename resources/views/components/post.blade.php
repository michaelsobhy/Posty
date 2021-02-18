@props(['post' => $post])
<div class="mb-4 border-2 p-2">
    <a href="{{ route('user.posts', $post->user) }}" class="font-bold">{{ $post->user->username }}</a> <span
        class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>
    <p class="mb-2">{{ $post->body }}</p>

    <div class="flex items-center">
        @auth()
            @if(!$post->likedBy(auth()->user()))
                <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                    @csrf
                    <button type="submit" class="text-blue-500">Like</button>
                </form>
            @else
                <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-yellow-500">Unlike</button>
                </form>
            @endif
            @can('delete', $post)
                <form action="{{ route('posts.delete', $post) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            @endcan
        @endauth
        <span>{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</span>
    </div>
    <div class="w-8/12 bg-white p-6 rounded-lg">
        <form action="{{ route('posts.comments', [$post]) }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="body" class="sr-only">Body</label>
                <textarea name="body" id="body" cols="10" rows="1"
                          class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body') border-red-400 @enderror"
                          placeholder="Add a comment..."></textarea>
                @error('body')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1.5 rounded font-medium">Comment</button>
            </div>
        </form>
    </div>
    <div class="w-8/12 mb-4 py-1 px-6">
        @if($post->comments() -> count())
            @foreach($post->comments as $comment)
                <x-comment :comment="$comment"/>
            @endforeach
        @else
            <p>There are no comments for this post</p>
        @endif
    </div>
</div>
