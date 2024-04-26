<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFavoriteRequest;
use Illuminate\Http\Response;

/**
 * @group Favorites
 *
 * API endpoints for managing favorites
 */
class FavoriteController extends Controller
{
    public function index(Request $request)
    {
//        $favorites = $request->user()->favorites;
//        return FavoriteResource::collection($favorites);
        $favorites = $request->user()->favorites()->with('favoritable')->get();
        $posts = [];
        $users = [];
        foreach ($favorites as $favorite) {
            $favoritable = $favorite->favoritable;

            if ($favoritable instanceof \App\Models\Post) {
                $posts[] = new PostResource($favoritable);
            } elseif ($favoritable instanceof \App\Models\User) {
                $users[] = new UserResource($favoritable);
            }
        }
        return response()->json([
            'data' => [
                'posts' => $posts,
                'users' => $users,
            ],
        ]);
    }

    public function store(CreateFavoriteRequest $request, Post $post)
    {
//        $request->user()->favorites()->create(['post_id' => $post->id]);
        $request->user()->favorites()->create([
            'favoritable_id' => $post->id,
            'favoritable_type' => Post::class,
        ]);

        return response()->noContent(Response::HTTP_CREATED);
    }

    public function destroy(Request $request, Post $post)
    {
//        $favorite = $request->user()->favorites()->where('post_id', $post->id)->firstOrFail();
        $favorite = $request->user()->favorites()
            ->where('favoritable_id', $post->id)
            ->where('favoritable_type', Post::class)
            ->firstOrFail();

        $favorite->delete();

        return response()->noContent();
    }

    public function favoriteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->noContent(Response::HTTP_FORBIDDEN);
        }

        auth()->user()->favoritedUsers()->syncWithoutDetaching($user->id);
        return response()->json(['message' => 'User favorited successfully.']);
    }

    public function unfavoriteUser(User $user)
    {
        auth()->user()->favoritedUsers()->detach($user->id);
        return response()->json(['message' => 'User unfavorited successfully.']);
    }
}
