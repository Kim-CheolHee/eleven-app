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
        $posts = Post::latest()->paginate(10); // 10개씩 페이징

        // 포맷팅된 작성일자 추가
        $posts->getCollection()->transform(function ($post) {
            $post->formatted_created_at = Carbon::parse($post->created_at)->format('m/d H:i');
            return $post;
        });

        return Inertia::render('ClassBoard/FourOne', [
            'posts' => $posts, // 페이지네이션 객체 그대로 전달
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
            $filePath = $request->file('file')->storeAs('uploads', $request->file('file')->getClientOriginalName(), 'public');
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
            'password' => ['required', 'string', 'size:4'], // 문자열이며 정확히 4글자인지 확인
        ]);

        if ($post->password !== $request->password) {
            return back()->withErrors(['password' => '비밀번호가 일치하지 않습니다.']);
        }

        $post->delete();
        return back();
    }
}
