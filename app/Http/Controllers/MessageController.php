<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $conversations = Message::query()
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(function ($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;
            })
            ->map(function ($messages) use ($user) {
                $last = $messages->last();
                $contactId = $last->sender_id === $user->id ? $last->receiver_id : $last->sender_id;

                return [
                    'contact' => User::find($contactId),
                    'last_message' => $last,
                    'unread_count' => 0,
                ];
            })
            ->values();

        return view('message.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id === $user->id) {
            abort(403);
        }

        $messages = Message::query()
            ->where(function ($query) use ($authUser, $user) {
                $query->where('sender_id', $authUser->id)->where('receiver_id', $user->id);
            })
            ->orWhere(function ($query) use ($authUser, $user) {
                $query->where('sender_id', $user->id)->where('receiver_id', $authUser->id);
            })
            ->orderBy('created_at')
            ->get();

        return view('message.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $authUser = Auth::user();

        $validated = $request->validate([
            'message' => ['nullable', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'max:2048'],
        ]);

        if (empty($validated['message']) && ! $request->hasFile('attachment')) {
            return redirect()->back()->with('error', 'Le message est vide.');
        }

        $attachmentPath = null;
        $attachmentName = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('messages', 'public');
            $attachmentName = $file->getClientOriginalName();
        }

        $message = Message::create([
            'sender_id' => $authUser->id,
            'receiver_id' => $user->id,
            'body' => $validated['message'] ?? '',
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Nouveau message',
            'message' => $authUser->name . ' vous a envoyé un message.',
            'type' => 'message',
            'related_id' => $message->id,
        ]);

        return redirect()->route('message.show', $user)->with('success', 'Message envoyé.');
    }
}
