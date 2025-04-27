<?php

namespace App\Http\Controllers;

use App\Models\FileSubmission;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show file submissions for a task
     */
    public function taskFiles($taskId)
    {
        $task = Task::with(['contract.client', 'contract.jobSeeker'])->findOrFail($taskId);
        
        // Check if the user is authorized to view this task's files
        if (Auth::id() !== $task->contract->client_id && Auth::id() !== $task->contract->job_seeker_id) {
            abort(403, 'Unauthorized access');
        }
        
        // Get all file submissions for this task
        $submissions = FileSubmission::where('task_id', $taskId)
            ->with('user')
            ->orderBy('created_at')
            ->get();
        
        return view('files.submission', compact('task', 'submissions'));
    }

    /**
     * Upload a file for a task
     */
    public function uploadFile(Request $request, $taskId)
    {
        $task = Task::with('contract')->findOrFail($taskId);
        
        // Check if the user is authorized to upload files for this task
        if (Auth::id() !== $task->contract->client_id && Auth::id() !== $task->contract->job_seeker_id) {
            abort(403, 'Unauthorized access');
        }
        
        // Validate the request
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:1000'
        ]);
        
        // Store the file
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('task_files', $filename, 'private');
        
        // Create file submission record
        FileSubmission::create([
            'task_id' => $taskId,
            'user_id' => Auth::id(),
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'filesize' => $file->getSize(),
            'description' => $request->description,
            'mime_type' => $file->getMimeType()
        ]);
        
        return redirect()->route('files.task', $taskId)->with('success', 'File uploaded successfully');
    }

    /**
     * Download a file
     */
    public function downloadFile($fileId)
    {
        $file = FileSubmission::with(['task.contract'])->findOrFail($fileId);
        
        // Check if the user is authorized to download this file
        if (Auth::id() !== $file->task->contract->client_id && Auth::id() !== $file->task->contract->job_seeker_id) {
            abort(403, 'Unauthorized access');
        }
        
        if (!Storage::disk('private')->exists($file->path)) {
            abort(404, 'File not found');
        }
        
        return Storage::disk('private')->download($file->path, $file->filename);
    }
    
    /**
     * Delete a file
     */
    public function deleteFile($fileId)
    {
        $file = FileSubmission::with(['task.contract'])->findOrFail($fileId);
        
        // Check if the user is authorized to delete this file (only uploader or client can delete)
        if (Auth::id() !== $file->user_id && Auth::id() !== $file->task->contract->client_id) {
            abort(403, 'Unauthorized access');
        }
        
        // Delete file from storage
        if (Storage::disk('private')->exists($file->path)) {
            Storage::disk('private')->delete($file->path);
        }
        
        // Delete record
        $file->delete();
        
        return redirect()->route('files.task', $file->task_id)->with('success', 'File deleted successfully');
    }
} 