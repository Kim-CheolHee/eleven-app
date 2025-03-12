<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        // 안전한 데이터 변환 방식 (`through()` 사용)
        $posts->through(function ($post) {
            $post->formatted_created_at = $post->created_at->format('d/m H:i'); // 라오스 스타일 d/m H:i
            return $post;
        });

        return Inertia::render('ClassBoard/FourOne', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'password' => 'required|digits:4',
            'file' => 'nullable|file|max:5120', // 5MB 제한
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $timestamp = now()->format('Ymd_His'); // 타임스탬프 (년월일_시분초)
            $fileName = $timestamp . '_' . $file->getClientOriginalName(); // 기존 파일명 유지 + 타임스탬프 추가
            $filePath = $file->storeAs('uploads', $fileName, 'public'); // 저장
        }

        Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author' => $validated['author'],
            'password' => $validated['password'],
            'file_path' => $filePath,
        ]);

        return redirect()->route('class.four_one');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        $request->validate([
            'password' => ['required', 'string', 'size:4'], // 4자리 숫자 확인
        ]);

        if ($post->password !== $request->password) {
            return back()->withErrors([
                'password' => '❌ ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ (Incorrect password.)'
            ]);
        }

        $post->delete();
        return back();
    }
}
