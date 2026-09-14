<?php
namespace App\Http\Controllers;
use App\Models\ProjectProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function index() {
        return view('profile.index', ['profile' => ProjectProfile::findOrFail(1)]);
    }
    public function edit() {
        return view('profile.edit', ['profile' => ProjectProfile::findOrFail(1)]);
    }
    public function update(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:5000',
            'email' => 'nullable|email|max:255',
            'github_url' => 'nullable|url:http,https|max:500',
            'website_url' => 'nullable|url:http,https|max:500',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_photo' => 'nullable|boolean',
        ]);
        $profile = ProjectProfile::findOrFail(1);
        $oldPhoto = $profile->photo;
        unset($data['photo'], $data['remove_photo']);
        $newPhoto = null;
        if ($request->hasFile('photo')) {
            $newPhoto = $request->file('photo')->store('profiles', 'public');
            $data['photo'] = $newPhoto;
        } elseif ($request->boolean('remove_photo')) {
            $data['photo'] = null;
        }
        try { $profile->update($data); }
        catch (\Throwable $exception) {
            if ($newPhoto) { Storage::disk('public')->delete($newPhoto); }
            throw $exception;
        }
        if ($oldPhoto && array_key_exists('photo', $data) && $oldPhoto !== $data['photo']) {
            Storage::disk('public')->delete($oldPhoto);
        }
        return redirect()->route('profile.index')->with('success', 'Profil pembuat berhasil diperbarui.');
    }
}
