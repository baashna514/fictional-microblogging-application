<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\DestroyPostRequest;
use App\Notifications\NewPostNotification;
use Illuminate\Support\Facades\Storage;

/**
 * @group Posts
 *
 * API endpoints for managing posts
 */
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->orderByDesc('created_at')->get();
        return PostResource::collection($posts);
    }

    public function store(CreatePostRequest $request)
    {
        $user = $request->user();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');

            $post = Post::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'image_url' => $imagePath,
                'user_id' => $user->id,
            ]);
        } else {
            $post = Post::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'user_id' => $user->id,
            ]);
        }

        $this->notifyFollowers($user, $post);

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        return new PostResource($post);
    }

    public function destroy(DestroyPostRequest $request, Post $post)
    {
        $post->delete();

        return response()->noContent();
    }


    protected function notifyFollowers($user, $post)
    {
        $followers = $user->favoritedUsers;
        foreach ($followers as $follower) {
            $follower->notify(new NewPostNotification($post));
        }
    }
}
