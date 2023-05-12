<?php

namespace App\Http\Controllers\profile;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class AvatarController extends Controller
{

    public function update(UpdateAvatarRequest $request)
    {
        $path = Storage::disk('public')->put('avatars', $request->file('avatar'));
        $request->file('avatar')->store('avatars', 'public');
        if ($oldAvatar = $request->user()->avatar) {
            Storage::disk('public')->delete($oldAvatar);
        }
        auth()->user()->update(['avatar' =>  $path]);
        return redirect(route('profile.edit'))->with('message', 'Avatar is updated');
    }

    public function generate(Request $request)
    {
        $result = OpenAI::images()->create([
            "prompt" => "crate an amazing male young avator for website, it should be realistic",
            "n" => 1,
            "size" => "256x256",
        ]);

        $contents = file_get_contents($result->data[0]->url);
        $filename = Str::random(25);
        if ($oldAvatar = $request->user()->avatar) {
            Storage::disk('public')->delete($oldAvatar);
        }
        Storage::disk('public')->put("avatars/$filename.jpg", $contents);
        auth()->user()->update(['avatar' =>  "avatars/$filename.jpg"]);
        return redirect(route('profile.edit'))->with('message', 'Avatar is updated');
    }
}
