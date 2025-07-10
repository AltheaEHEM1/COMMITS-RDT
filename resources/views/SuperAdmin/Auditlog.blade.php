@extends('layouts.app-layoutadmin')

@section('title', 'Audit Log')

@section('content')
        <x-page-title value="Audit Log" class="mb-0" />
        <p class="text-sm text-gray-500 mb-7">A record of all recent actions performed within the system, including created, updated, and deleted items.</p>
        
        @php
            $groupedLogs = $logs->groupBy(function ($log) {
                return \Carbon\Carbon::parse($log->created_at)->format('l, F j, Y');
            });
        @endphp

        @if ($groupedLogs->isEmpty())
            <p class="text-gray-600 text-center">No activity logs available.</p>
        @else
        @foreach ($groupedLogs as $date => $dateLogs)
                

            <div class="mx-automax-w-5xl px-4 sm:px-6 lg:px-8 py-6">
                <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm max-w-5xl">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">{{ $date }}</h2>

                    <ul class="space-y-3 align-middle">
                    @php
                        $loginAttempts = [];
                        $logItems = collect();
                    @endphp
                    @foreach ($dateLogs as $log)
                        @if ($log->description !== 'logged in')
                            @if (in_array($log->description, ['logged in successfully', 'logged out', 'failed login attempt']))
                                @if ($log->description == 'failed login attempt')
                                    @php
                                        $loginAttempts[$log->causer_id] = ($loginAttempts[$log->causer_id] ?? 0) + 1;
                                    @endphp
                                @endif
                            @endif
                            @php
                                $logItems->push($log);
                            @endphp
                        @endif
                    @endforeach
                    @foreach ($loginAttempts as $userId => $count)
                        @if($count > 1)
                            @php
                                $user = \App\Models\User::find($userId);
                                $logItems->push((object)[
                                    'is_attempt_badge' => true,
                                    'user' => $user,
                                    'count' => $count
                                ]);
                            @endphp
                        @endif
                    @endforeach
                    @foreach ($logItems as $loopIndex => $log)
                        <li class="flex items-center space-x-4 history-item relative mt-2">
                            @php
                                // SVG and color logic (from user's original code)
                                $iconBg = 'bg-gray-400';
                                $svg = '';
                                if(isset($log->is_attempt_badge) && $log->is_attempt_badge) {
                                    // Use login/logout SVG and gray background
                                    $svg = '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/></svg>';
                                } elseif(isset($log->description)) {
                                    if($log->description == 'created') {
                                        $iconBg = 'bg-green-500';
                                        $svg = '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v6.41A7.5 7.5 0 1 0 10.5 22H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M9 16a6 6 0 1 1 12 0 6 6 0 0 1-12 0Zm6-3a1 1 0 0 1 1 1v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 1 1 0-2h1v-1a1 1 0 0 1 1-1Z" clip-rule="evenodd"/></svg>';
                                    } elseif($log->description == 'updated') {
                                        $iconBg = 'bg-blue-500';
                                        $svg = '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8 7V2.221a2 2 0 0 0-.5.365L3.586 6.5a2 2 0 0 0-.365.5H8Zm2 0V2h7a2 2 0 0 1 2 2v.126a5.087 5.087 0 0 0-4.74 1.368v.001l-6.642 6.642a3 3 0 0 0-.82 1.532l-.74 3.692a3 3 0 0 0 3.53 3.53l3.694-.738a3 3 0 0 0 1.532-.82L19 15.149V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M17.447 8.08a1.087 1.087 0 0 1 1.187.238l.002.001a1.088 1.088 0 0 1 0 1.539l-.377.377-1.54-1.542.373-.374.002-.001c.1-.102.22-.182.353-.237Zm-2.143 2.027-4.644 4.644-.385 1.924 1.925-.385 4.644-4.642-1.54-1.54Zm2.56-4.11a3.087 3.087 0 0 0-2.187.909l-6.645 6.645a1 1 0 0 0-.274.51l-.739 3.693a1 1 0 0 0 1.177 1.176l3.693-.738a1 1 0 0 0 .51-.274l6.65-6.646a3.088 3.088 0 0 0-2.185-5.275Z" clip-rule="evenodd"/></svg>';
                                    } elseif($log->description == 'deleted') {
                                        $iconBg = 'bg-red-500';
                                        $svg = '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/></svg>';
                                    } elseif(in_array($log->description, ['logged out', 'logged in successfully', 'failed login attempt'])) {
                                        $iconBg = 'bg-gray-400';
                                        $svg = '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/></svg>';
                                    }
                                }
                            @endphp
                            <div class="flex items-center justify-center w-10 h-10 {{ $iconBg }} text-white rounded-full relative">
                                {!! $svg !!}
                                @if($loopIndex !== $logItems->count() - 1)
                                    <div class="w-1 h-full {{ $iconBg }} absolute left-1/2 top-full transform -translate-x-1/2"></div>
                                @endif
                            </div>
                            @if(isset($log->is_attempt_badge) && $log->is_attempt_badge)
                                <div class="flex flex-col justify-center">
                                    <span class="text-md text-gray-800 font-medium">
                                        {{ $log->user->email }}
                                        <span class="font-normal text-gray-600 text-md"> tried to log in <span class="text-red-500">{{ $log->count }}</span> {{ Str::plural('time', $log->count) }}</span>
                                    </span>
                                </div>
                            @else
                                <div class="flex flex-col justify-center">
                                    <span class="text-md text-gray-800 font-medium">
                                        @if ($log->causer)
                                            {{ $log->causer->email }}
                                        @else
                                            System
                                        @endif
                                        <span class="font-normal text-gray-600 text-md"> {{ strtolower($log->description) }}
                                            @if($log->subject_type !== 'App\\Models\\User' && isset($log->subject_type))
                                                <span class="subject-type font-bold
                                                    @if ($log->description == 'created')
                                                        text-green-500
                                                    @elseif ($log->description == 'updated')
                                                        text-blue-500
                                                    @elseif ($log->description == 'deleted')
                                                        text-red-500
                                                    @else
                                                        text-gray-400
                                                    @endif
                                                    " data-raw="{{ class_basename($log->subject_type) }}">
                                                    {{ isset($log->properties['attributes']['document_type']) ? $log->properties['attributes']['document_type'] : '' }}
                                                </span>
                                            @endif
                                            @if($log->description == 'logged in successfully' && isset($log->properties['ip_address']))
                                                <span class="font-normal text-gray-600 text-md"> from {{ $log->properties['ip_address'] }}</span>
                                            @endif
                                            @if($log->description == 'failed login attempt' && isset($log->properties['ip_address']))
                                                <span class="font-normal text-red-600 text-md"> from {{ $log->properties['ip_address'] }}</span>
                                            @endif
                                            <span> | </span>
                                            <span class="text-gray-500 font-medium">
                                                {{ $log->created_at->format('h:i A') }}
                                            </span>
                                        </span>
                                    </span>
                                </div>
                            @endif
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    @endif

<div class="mt-4">
    {{ $logs->links() }}
</div>


@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const subjectElements = document.querySelectorAll('.subject-type');

        subjectElements.forEach(el => {
            const raw = el.dataset.raw;

            // Split based on capital letters (e.g., DMDCFormatForm => DMDC Format Form)
            const formatted = raw.replace(/([a-z])([A-Z])/g, '$1 $2')
                                 .replace(/([A-Z]+)([A-Z][a-z])/g, '$1 $2') // handle acronyms like DMDC
                                 .trim();

            el.textContent = formatted;
        });
    });
</script>
@endpush