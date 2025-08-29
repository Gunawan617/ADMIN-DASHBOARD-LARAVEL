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
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = Book::all();
            return response()->json($books);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display a listing of books for admin web interface.
     */
    public function indexWeb()
    {
        $books = Book::all();
        return view('admin.book.index', compact('books'));
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
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
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|max:5120', // 5MB
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
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|max:5120',
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
