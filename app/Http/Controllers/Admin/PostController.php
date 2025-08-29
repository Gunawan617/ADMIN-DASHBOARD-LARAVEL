<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // API: List semua post
    public function indexApi()
    {
        $posts = Post::with(['author', 'category', 'tags'])->latest()->paginate(10);
        $posts->getCollection()->transform(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'summary' => $post->summary,
                'content' => $post->content,
                'image' => $post->image,
                'meta_title' => $post->meta_title,
                'meta_description' => $post->meta_description,
                'meta_keywords' => $post->meta_keywords,
                'canonical_url' => $post->canonical_url,
                'published_at' => $post->published_at,
                'status' => $post->status,
                'author' => $post->author,
                'category' => $post->category,
                'tags' => $post->tags,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
        });
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    // API: Tampilkan detail post
    public function showApi($id)
    {
        $post = Post::with(['author', 'category', 'tags'])->find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'summary' => $post->summary,
                'content' => $post->content,
                'image' => $post->image,
                'meta_title' => $post->meta_title,
                'meta_description' => $post->meta_description,
                'meta_keywords' => $post->meta_keywords,
                'canonical_url' => $post->canonical_url,
                'published_at' => $post->published_at,
                'status' => $post->status,
                'author' => $post->author,
                'category' => $post->category,
                'tags' => $post->tags,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ]
        ]);
    }

    // API: Simpan post baru
    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'status' => 'nullable|in:draft,published,archived',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|exists:tags,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => $imagePath,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'canonical_url' => $request->canonical_url,
            'published_at' => $request->published_at,
            'status' => $request->status ?? 'draft',
            'author' => $request->author,
            'category' => $request->category,
        ]);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully.',
            'data' => $post
        ], 201);
    }

    // API: Update post
    public function updateApi(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found.'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'status' => 'nullable|in:draft,published,archived',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|exists:tags,id',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                \Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => $post->image,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'canonical_url' => $request->canonical_url,
            'published_at' => $request->published_at,
            'status' => $request->status ?? 'draft',
            'author' => $request->author,
            'category' => $request->category,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully.',
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'summary' => $post->summary,
                'content' => $post->content,
                'image' => $post->image,
                'meta_title' => $post->meta_title,
                'meta_description' => $post->meta_description,
                'meta_keywords' => $post->meta_keywords,
                'canonical_url' => $post->canonical_url,
                'published_at' => $post->published_at,
                'status' => $post->status,
                'author' => $post->author,
                'category' => $post->category,
                'tags' => $post->tags,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ]
        ]);
    }

    // API: Hapus post
    public function destroyApi($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found.'
            ], 404);
        }
        if ($post->image) {
            \Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully.'
        ]);
    }
    // List semua post
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    // Tampilkan form create
    public function create()
    {
        return view('admin.posts.create');
    }

    // Simpan post baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'status' => 'nullable|in:draft,published,archived',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|exists:tags,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => $imagePath,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'canonical_url' => $request->canonical_url,
            'published_at' => $request->published_at,
            'status' => $request->status ?? 'draft',
            'author' => $request->author,
            'category' => $request->category,
        ]);

            return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    // Tampilkan form edit
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    // Update post
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'status' => 'nullable|in:draft,published,archived',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|exists:tags,id',
        ]);

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($post->image) {
                \Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => $post->image,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'canonical_url' => $request->canonical_url,
            'published_at' => $request->published_at,
            'status' => $request->status ?? 'draft',
            'author' => $request->author,
            'category' => $request->category,
        ]);

            return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    // Hapus post
    public function destroy(Post $post)
    {
        if ($post->image) {
            \Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    public function showBySlug($slug)
{
    $post = Post::where('slug', $slug)->first();
    if (!$post) {
        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }
    return response()->json(['success' => true, 'data' => $post]);
}
}
