@extends('layouts.app')

@section('title', 'How to Find Work | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-blue-50 dark:from-gray-800 to-white dark:to-gray-900">
	<div class="container mx-auto px-6 text-center">
		<h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">How to Find Work</h1>
		<p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">Tips and resources to help you land freelance jobs on Ajira.</p>
	</div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
	<div class="container mx-auto px-6">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
			<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
				<h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Polish Your Profile</h3>
				<p class="text-gray-600 dark:text-gray-400">Showcase your best work, skills, and a compelling summary.</p>
			</div>
			<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
				<h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Search & Save Jobs</h3>
				<p class="text-gray-600 dark:text-gray-400">Use filters to find relevant jobs and save them for later.</p>
			</div>
			<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
				<h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Send Quality Proposals</h3>
				<p class="text-gray-600 dark:text-gray-400">Tailor your pitch to the client’s needs and include samples.</p>
			</div>
		</div>

		<div class="text-center">
			<a href="{{ route('freelancer.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Browse Freelancers</a>
		</div>
	</div>
</div>
@endsection


