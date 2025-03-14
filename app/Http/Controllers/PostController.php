<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($class_id)
    {
        $classMap = [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
        ];

        if (!isset($classMap[$class_id])) {
            abort(404); // 유효하지 않은 class_id 요청 시 404 반환
        }

        $posts = Post::where('class_id', $class_id)
                     ->latest()
                     ->paginate(10);

        $posts->through(function ($post) {
            $post->formatted_created_at = $post->created_at->format('d/m H:i');
            return $post;
        });

        return Inertia::render("ClassBoard/Four{$classMap[$class_id]}", [
            'posts' => $posts,
            'class_id' => $class_id,
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
            'file' => 'nullable|file|max:5120',
            'class_id' => 'required|integer|min:1|max:4', // 필수: 1~4만 허용
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $timestamp = now()->format('Ymd_His');
            $fileName = $timestamp . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
        }

        Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author' => $validated['author'],
            'password' => $validated['password'],
            'file_path' => $filePath,
            'class_id' => $validated['class_id'], // 게시판 ID 저장
        ]);

        return redirect()->route("class.board", ['class_id' => $validated['class_id']]);
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
    public function update(Request $request, $class_id, $post_id)
    {
        $post = Post::where('id', $post_id)->where('class_id', $class_id)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'password' => 'required|string|min:4|max:4',
            'file' => 'nullable|file|max:5120',
        ]);

        if ($post->password !== $request->input('password')) {
            return back()->withErrors(['password' => '❌ ລະຫັດບໍ່ຖືກຕ້ອງ (Incorrect password)']);
        }

        $filePath = $post->file_path;
        if ($request->hasFile('file')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $file = $request->file('file');
            $fileName = now()->format('Ymd_His') . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
        }

        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'file_path' => $filePath,
        ]);

        return redirect()->route('class.board', ['class_id' => $class_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $class_id, $post_id)
    {
        $request->validate([
            'password' => ['required', 'string', 'size:4'], // 4자리 숫자 확인
        ]);

        // 직접 ID로 게시글 조회
        $post = Post::where('class_id', $class_id)->findOrFail($post_id);

        if ($post->password !== $request->password) {
            return back()->withErrors([
                'password' => '❌ ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ (Incorrect password.)'
            ]);
        }

        $post->delete();
        return back();
    }
}
