@extends('layouts.app')

@section('title', 'Task Workspace | Ajira Global')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>{{ $task['title'] }}</h3>
                    <span class="badge {{ $task['status'] == 'completed' ? 'bg-success' : ($task['status'] == 'in_progress' ? 'bg-primary' : 'bg-warning') }}">
                        {{ ucfirst(str_replace('_', ' ', $task['status'])) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Client:</strong> {{ $task['client_name'] }}</p>
                            <p><strong>Priority:</strong> 
                                <span class="badge {{ $task['priority'] == 'high' ? 'bg-danger' : ($task['priority'] == 'medium' ? 'bg-warning' : 'bg-info') }}">
                                    {{ ucfirst($task['priority']) }}
                                </span>
                            </p>
                            <p><strong>Due Date:</strong> {{ $task['due_date'] }}</p>
                        </div>
                        <div class="col-md-6">
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" style="width: {{ $task['progress'] }}%;" aria-valuenow="{{ $task['progress'] }}" aria-valuemin="0" aria-valuemax="100">{{ $task['progress'] }}%</div>
                            </div>
                            <p class="text-end"><strong>Payment:</strong> ${{ $task['payment'] }}</p>
                            @if(isset($task['contract_details']))
                                <p class="text-end"><small>Contract: {{ $task['contract_details'] }}</small></p>
                            @endif
                        </div>
                    </div>
                    
                    <h5>Task Description</h5>
                    <div class="mb-4">
                        {!! nl2br(e($task['description'])) !!}
                    </div>
                    
                    @if(count($task['attachments'] ?? []) > 0)
                    <h5>Attachments</h5>
                    <div class="mb-4">
                        <ul class="list-group">
                            @foreach($task['attachments'] as $attachment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $attachment['name'] }}</span>
                                <a href="{{ $attachment['url'] }}" class="btn btn-sm btn-outline-primary" download>Download</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <h5>Submit Work</h5>
                    @if($task['status'] != 'completed')
                    <form action="{{ route('jobseeker.submit-work', ['taskId' => $task['id']]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="work_description" class="form-label">Description of work</label>
                            <textarea class="form-control" id="work_description" name="work_description" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="hours_worked" class="form-label">Hours Worked</label>
                            <input type="number" class="form-control" id="hours_worked" name="hours_worked" step="0.5" min="0" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="submission_type" class="form-label">Submission Type</label>
                            <select class="form-control" id="submission_type" name="submission_type" onchange="toggleSubmissionFields()">
                                <option value="file">File Upload</option>
                                <option value="link">Link</option>
                                <option value="text">Text Only</option>
                            </select>
                        </div>
                        
                        <div id="file_field" class="mb-3">
                            <label for="submission_file" class="form-label">Upload File</label>
                            <input type="file" class="form-control" id="submission_file" name="submission_file">
                        </div>
                        
                        <div id="link_field" class="mb-3 d-none">
                            <label for="submission_link" class="form-label">Submission Link</label>
                            <input type="url" class="form-control" id="submission_link" name="submission_link">
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_final" name="is_final">
                            <label class="form-check-label" for="is_final">
                                This is the final submission
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit Work</button>
                    </form>
                    @else
                    <div class="alert alert-success">
                        This task has been completed. Thank you for your work!
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h4>Previous Submissions</h4>
                </div>
                <div class="card-body">
                    @if(count($task['submissions'] ?? []) > 0)
                        <ul class="list-group">
                            @foreach($task['submissions'] as $submission)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $submission['created_at'] }}</span>
                                    <span class="badge {{ $submission['is_final'] ? 'bg-success' : 'bg-info' }}">
                                        {{ $submission['is_final'] ? 'Final' : 'Draft' }}
                                    </span>
                                </div>
                                <p class="mb-1 mt-1">{{ $submission['work_description'] }}</p>
                                <p class="mb-1"><small>Hours: {{ $submission['hours_worked'] }}</small></p>
                                
                                @if($submission['submission_type'] == 'file')
                                    <a href="{{ $submission['file_url'] }}" class="btn btn-sm btn-outline-secondary" download>
                                        Download File
                                    </a>
                                @elseif($submission['submission_type'] == 'link')
                                    <a href="{{ $submission['link'] }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                        Open Link
                                    </a>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No submissions yet.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Messages</h5>
                </div>
                <div class="card-body message-container" style="max-height: 400px; overflow-y: auto;">
                    @if(count($messages) > 0)
                        @foreach($messages as $message)
                            <div class="message-bubble mb-3 {{ $message->sender_id == auth()->id() ? 'text-end' : 'text-start' }}">
                                <div class="message-content p-2 {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }} d-inline-block rounded">
                                    <p class="mb-1">{{ $message->content }}</p>
                                    <small class="text-muted">{{ $message->created_at->format('M d, g:i a') }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">No messages yet.</p>
                    @endif
                </div>
                <div class="card-footer">
                    <form action="{{ route('jobseeker.send-message', ['taskId' => $task['id']]) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Type your message...">
                            <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5>Client Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $client->name ?? $task['client_name'] }}</p>
                    @if(isset($client->email))
                    <p><strong>Email:</strong> {{ $client->email }}</p>
                    @endif
                    @if(isset($client->phone))
                    <p><strong>Phone:</strong> {{ $client->phone }}</p>
                    @endif
                    <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-outline-secondary btn-sm d-block mt-3">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSubmissionFields() {
        const submissionType = document.getElementById('submission_type').value;
        
        if (submissionType === 'file') {
            document.getElementById('file_field').classList.remove('d-none');
            document.getElementById('link_field').classList.add('d-none');
        } else if (submissionType === 'link') {
            document.getElementById('file_field').classList.add('d-none');
            document.getElementById('link_field').classList.remove('d-none');
        } else {
            document.getElementById('file_field').classList.add('d-none');
            document.getElementById('link_field').classList.add('d-none');
        }
    }
    
    // Auto-scroll to bottom of message container
    document.addEventListener('DOMContentLoaded', function() {
        const messageContainer = document.querySelector('.message-container');
        if (messageContainer) {
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }
    });
</script>
@endsection