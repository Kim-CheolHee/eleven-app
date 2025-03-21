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
            'image' => 'nullable|image|max:5120', // 이미지 파일 제한 (최대 5MB)
            'is_visible' => 'nullable|boolean',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $timestamp = now()->format('Ymd_His'); // 현재 날짜 및 시간 추가 (예: 20250312_193000)
            $fileName = $timestamp . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('announcements', $fileName, 'public'); // 저장 위치: storage/app/public/announcements
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $timestamp = now()->format('Ymd_His');
            $imageName = $timestamp . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('announcements/images', $imageName, 'public');
        }

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $filePath,
            'image_path' => $imagePath,
            'is_visible' => $request->boolean('is_visible'),
        ]);

        return redirect()->route('announcement.index');
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'is_visible' => 'nullable|boolean',
        ]);

        $imagePath = $announcement->image_path;
        if ($request->hasFile('image')) {
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $image = $request->file('image');
            $timestamp = now()->format('Ymd_His');
            $imageName = $timestamp . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('announcements/images', $imageName, 'public');
        }

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
            'is_visible' => (bool) $request->input('is_visible'),
        ]);

        return redirect()->route('announcement.index');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        if ($announcement->file_path) {
            Storage::disk('public')->delete($announcement->file_path);
        }

        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();

        return redirect()->route('announcement.index');
    }
}
