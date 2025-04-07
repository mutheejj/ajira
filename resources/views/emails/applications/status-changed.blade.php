@component('mail::message')
# Your Job Application Status Has Changed

Dear {{ $application->user->name }},

Your application for **{{ $jobPost->title }}** has been **{{ ucfirst($newStatus) }}**.

@if($newStatus == 'accepted')
## Congratulations!
Your application has been accepted by the client. They have chosen you for this opportunity.

@component('mail::panel')
### Next Steps:
1. The client may reach out to you directly via the platform's messaging system
2. Be ready to discuss project details and timelines
3. Ensure your payment details are up-to-date in your profile settings
@endcomponent

@elseif($newStatus == 'rejected')
We're sorry to inform you that the client has chosen to move forward with other candidates at this time.
@elseif($newStatus == 'withdrawn')
This is a confirmation that you have withdrawn your application for this job post.
@else
Your application status has been updated from "{{ ucfirst($oldStatus) }}" to "{{ ucfirst($newStatus) }}".
@endif

@if($feedback)
## Feedback from the Client:
@component('mail::panel')
{{ $feedback }}
@endcomponent
@endif

@component('mail::button', ['url' => route('applications.show', $application->id)])
View Application Details
@endcomponent

Don't be discouraged! There are many more opportunities available on Ajira Global.

@component('mail::button', ['url' => route('jobs.index'), 'color' => 'success'])
Browse More Jobs
@endcomponent

Thank you for using Ajira Global!

Regards,<br>
{{ config('app.name') }} Team

<small>This is an automated message. Please do not reply to this email.</small>
@endcomponent 