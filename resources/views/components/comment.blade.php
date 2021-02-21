@props(['comment' => $comment])
<div class="mb-4">
    <a href="" class="font-medium">{{ $comment->user->username }}</a> <span
        class="text-gray-600 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
    <p class="mb-2 text-sm">{{ $comment->body }}</p>

    <div class="flex items-center">
        @auth()
            @can('delete', $comment)
                <form action="{{ route('comments.delete', $comment) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            @endcan
        @endauth
    </div>
</div>
