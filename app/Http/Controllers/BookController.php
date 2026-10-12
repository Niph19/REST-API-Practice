<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::query()
            ->select(['id', 'title', 'author', 'published_year'])
            ->orderBy('id')
            ->get();

        return response()->json(['data' => $books]);
    }

    public function store(Request $request)
    {
        
        if (!$request->validate([
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:100',
            'published_year' => 'required|integer|min:1900|max:2026',
        ])) {
            return response()->json(['message' => 'Data tidak valid'], 422);
        }
        else {$request->validate([
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:100',
            'published_year' => 'required|integer|min:1900|max:2026',
        ]);

        $book = Book::create($request->all());

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data' => $book
        ], 201);
        }
    }

    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Buku ditemukan',
            'data' => $book
            ]);
    }
}
