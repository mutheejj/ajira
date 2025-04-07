@component('mail::message')
# New Job Application Received

Dear {{ $client->name }},

Good news! You've received a new application for your job posting: **{{ $jobPost->title }}**.

## Applicant Information:
- Name: {{ $applicant->name }}
- Applied: {{ $application->created_at->format('F j, Y g:i A') }}
- Bid Amount: {{ $jobPost->currency }} {{ number_format($application->bid_amount, 2) }}
  @if($jobPost->rate_type === 'hourly')
  per hour
  @endif
- Estimated Duration: {{ $application->estimated_duration }}

## Cover Letter Preview:
@component('mail::panel')
{{ \Illuminate\Support\Str::limit($application->cover_letter, 300) }}
@if(strlen($application->cover_letter) > 300)
...
@endif
@endcomponent

@component('mail::button', ['url' => route('applications.show', $application->id)])
View Full Application
@endcomponent

You can review this application, along with others, from your client dashboard.

Thank you for using Ajira Global!

Regards,<br>
{{ config('app.name') }} Team

<small>This is an automated message. Please do not reply to this email.</small>
@endcomponent 