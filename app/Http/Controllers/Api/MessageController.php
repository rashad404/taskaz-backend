<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Get messages for a specific task.
     */
    public function index($taskId, Request $request)
    {
        $task = Task::findOrFail($taskId);
        $user = Auth::user();

        // Check if user is involved in this task (as client or has an application)
        $isClient = $task->user_id === $user->id;
        $hasApplication = $task->applications()->where('user_id', $user->id)->exists();

        if (!$isClient && !$hasApplication) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        $messages = Message::where('task_id', $taskId)
            ->where(function($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark received messages as read
        Message::where('task_id', $taskId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'status' => 'success',
            'data' => $messages
        ]);
    }

    /**
     * Send a message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $task = Task::findOrFail($validated['task_id']);
        $user = Auth::user();

        // Check if user can send messages for this task
        $isClient = $task->user_id === $user->id;
        $hasApplication = $task->applications()->where('user_id', $user->id)->exists();

        if (!$isClient && !$hasApplication) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bu tapşırıqla bağlı mesaj göndərmək üçün tapşırığın sahibi olmmalı və ya bu tapşırığa müraciət etmiş olmalısınız'
            ], 403);
        }

        $validated['sender_id'] = $user->id;
        $validated['is_read'] = false;

        $message = Message::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully',
            'data' => $message->load(['sender', 'receiver'])
        ], 201);
    }

    /**
     * Get unread message count for authenticated user.
     */
    public function unreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'status' => 'success',
            'data' => ['unread_count' => $count]
        ]);
    }

    /**
     * Get all conversations for authenticated user.
     */
    public function conversations(Request $request)
    {
        $user = Auth::user();

        // Get unique tasks where user has messages
        $taskIds = Message::where(function($q) use ($user) {
            $q->where('sender_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        })
        ->distinct()
        ->pluck('task_id');

        $conversations = Task::whereIn('id', $taskIds)
            ->with(['client', 'category'])
            ->withCount(['messages as unread_count' => function($q) use ($user) {
                $q->where('receiver_id', $user->id)
                  ->where('is_read', false);
            }])
            ->get()
            ->map(function($task) use ($user) {
                $lastMessage = Message::where('task_id', $task->id)
                    ->where(function($q) use ($user) {
                        $q->where('sender_id', $user->id)
                          ->orWhere('receiver_id', $user->id);
                    })
                    ->latest()
                    ->first();

                return [
                    'task' => $task,
                    'last_message' => $lastMessage,
                    'unread_count' => $task->unread_count,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $conversations
        ]);
    }
}
