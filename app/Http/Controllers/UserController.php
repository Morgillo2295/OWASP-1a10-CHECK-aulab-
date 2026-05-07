<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Forbidden Operation'], 403);
        }

        return view('auth.profile', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $authUser = Auth::user();

        if (! $authUser || ($authUser->id !== $user->id && ! $authUser->isAdmin())) {
            return response()->json(['message' => 'Forbidden Operation'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
        ]);

        if (empty($validated)) {
            return back()->with('message', 'No data to update');
        }

        $user->update($validated);

        return back()->with('message', 'User updated');
    }

    public function changeEmail(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Forbidden Operation'], 403);
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->email = $validated['email'];
        $user->save();

        return back()->with('message', 'Changed successfully');
    }

    public function changeName(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Forbidden Operation'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->name = $validated['name'];
        $user->save();

        return back()->with('message', 'Changed successfully');
    }

    public function changeImg(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return back()->with('message', 'Please Log In');
        }

        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $avatar = $validated['avatar'];
        $newImageHash = hash_file('sha256', $avatar->getRealPath());

        if ($newImageHash === $user->avatar) {
            return back()->with('message', 'Image not updated, same');
        }

        $path = "images/users/{$user->id}";
        Storage::disk('public')->deleteDirectory($path);

        $filename = $newImageHash . '.' . $avatar->extension();
        $avatar->storeAs($path, $filename, 'public');

        $user->avatar = $filename;
        $user->save();

        return back()->with('message', 'Image updated');
    }

    public function download(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Forbidden Operation'], 403);
        }

        $allowedFiles = ['privacy.pdf', 'cookie-policy.pdf'];
        $filename = basename($request->query('filename', ''));

        if (! $filename || ! in_array($filename, $allowedFiles, true)) {
            return response()->json(['message' => 'Invalid file request'], 400);
        }

        $fullPath = storage_path('app/private/' . $filename);

        if (! file_exists($fullPath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return response()->download($fullPath);
    }

    public function upload(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return back()->with('message', 'Please Log In');
        }

        $validated = $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:10240',
        ]);

        $file = $validated['file'];
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = preg_replace('/[^A-Za-z0-9_\-.]/', '_', $filename) . '.' . $file->extension();
        $path = "private/docs/users/{$user->id}";

        Storage::disk('local')->putFileAs($path, $file, $filename);

        return back()->with('message', 'Upload successful');
    }
}
