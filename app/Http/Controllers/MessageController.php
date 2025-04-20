<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display messages for a specific task.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function taskMessages($taskId)
    {
        $task = Task::with(['contract.client', 'contract.jobSeeker'])->findOrFail($taskId);
        
        // Check if user is authorized to view messages for this task
        $user = Auth::user();
        if ($user->id !== $task->contract->client_id && $user->id !== $task->contract->job_seeker_id) {
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to view messages for this task.');
        }
        
        // Get the other user (client or job seeker)
        $otherUser = ($user->id === $task->contract->client_id) 
            ? $task->contract->jobSeeker 
            : $task->contract->client;
        
        // Get messages for this task
        $messages = Message::where('task_id', $taskId)
            ->where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark unread messages as read
        Message::where('task_id', $taskId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('messages.task', compact('task', 'messages', 'otherUser'));
    }
    
    /**
     * Send a message for a specific task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function sendTaskMessage(Request $request, $taskId)
    {
        $task = Task::with(['contract.client', 'contract.jobSeeker'])->findOrFail($taskId);
        
        // Check if user is authorized to send messages for this task
        $user = Auth::user();
        if ($user->id !== $task->contract->client_id && $user->id !== $task->contract->job_seeker_id) {
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to send messages for this task.');
        }
        
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        
        // Determine the receiver
        $receiverId = ($user->id === $task->contract->client_id) 
            ? $task->contract->job_seeker_id 
            : $task->contract->client_id;
        
        // Create the message
        $message = new Message();
        $message->sender_id = $user->id;
        $message->receiver_id = $receiverId;
        $message->task_id = $taskId;
        $message->content = $request->content;
        $message->save();
        
        return redirect()->route('messages.task', $taskId)
            ->with('success', 'Message sent successfully.');
    }
    
    /**
     * Get unread message count for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function unreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }
}
