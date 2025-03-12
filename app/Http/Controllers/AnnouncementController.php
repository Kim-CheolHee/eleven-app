<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get(); // 최근 공지부터 정렬

        return Inertia::render('Announcement', [
            'announcements' => $announcements, // 공지사항 목록 전달
        ]);
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return Inertia::render('AnnouncementDetail', ['announcement' => $announcement]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|file|max:5120', // 파일 업로드 제한 (최대 5MB)
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $timestamp = now()->format('Ymd_His'); // 현재 날짜 및 시간 추가 (예: 20250312_193000)
            $fileName = $timestamp . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('announcements', $fileName, 'public'); // 저장 위치: storage/app/public/announcements
        }

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $filePath,
        ]);

        return redirect()->route('announcement.index');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        // 파일이 존재하면 삭제
        if ($announcement->file_path) {
            Storage::disk('public')->delete($announcement->file_path);
        }

        $announcement->delete();

        return redirect()->route('announcement.index');
    }
}
