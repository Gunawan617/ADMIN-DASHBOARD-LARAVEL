<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource (API for public).
     */
    public function index(Request $request)
    {
        try {
            $query = Book::where('status', 'published');
            
            // Filter by audience_type if provided
            if ($request->has('audience_type')) {
                $query->where('audience_type', $request->audience_type);
            }
            
            // Search by title or author
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
                });
            }
            
            $books = $query->latest()->get();
            
            // Convert cover_image path to full URL
            $books = $books->map(function($book) {
                if (!empty($book->cover_image) && !filter_var($book->cover_image, FILTER_VALIDATE_URL)) {
                    $book->cover_image = asset('storage/' . $book->cover_image);
                }
                return $book;
            });
            
            return response()->json([
                'success' => true,
                'data' => $books
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of books for admin web interface.
     */
    public function indexWeb(Request $request)
    {
        $query = Book::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by audience_type
        if ($request->has('audience_type') && $request->audience_type != '') {
            $query->where('audience_type', $request->audience_type);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $books = $query->latest()->paginate(15)->withQueryString();
        $categories = Book::distinct()->pluck('category')->filter();
        
        return view('admin.book.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }
        $book = Book::create($data);
        return response()->json($book, 201);
    }

    /**
     * Display the specified resource (API for public).
     */
    public function show(string $id)
    {
        $book = Book::where('status', 'published')->findOrFail($id);
        
        // Convert cover_image path to full URL
        if (!empty($book->cover_image) && !filter_var($book->cover_image, FILTER_VALIDATE_URL)) {
            $book->cover_image = asset('storage/' . $book->cover_image);
        }
        
        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }

    /**
     * Display the specified book for admin web interface.
     */
    public function showWeb(string $id)
    {
        $book = Book::findOrFail($id);
        return view('admin.book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('admin.book.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $book = Book::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }
        $book->update($data);
        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully.']);
    }

    /* ===========================
     *   WEB METHODS (ADMIN DASHBOARD)
     * =========================== */

    /**
     * Store a newly created book from web form.
     */
    public function storeWeb(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'audience_type' => 'required|in:nurse,midwife',
            'buy_link' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|max:51200', // 5MB
        ], [
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, GIF, WebP, BMP.',
            'cover_image.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Update the specified book from web form.
     */
    public function updateWeb(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|max:51200',
        ], [
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, GIF, WebP, BMP.',
            'cover_image.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified book from web interface.
     */
    public function destroyWeb(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku berhasil dihapus.');
    }
}
