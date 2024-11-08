<x-app-layout>
    @if($user->profile->role === 'owner')
        <div>
            @foreach($user->pets as $pet)
                <p>Applications for: {{ $pet->name }}</p>
                @foreach($pet->SittingRequests->where('end_date', '<', now()) as $sittingRequest)
                    @foreach($sittingRequest->applications as $application)
                        @if(empty($application->review))
                        <a href="{{ route('review.create', $application) }}">
                        @endif
                            <div>
                                <p>{{ $application->sitter->name }}</p>
                                <p>{{ $application->message }}</p>
                            </div>
                            @if(empty($application->review))
                            <p>Review</p>
                        </a>
                            @endif
                        <br>
                    @endforeach
                @endforeach

                @foreach($pet->SittingRequests->where('end_date', '>', now()) as $sittingRequest)
                    <h2>Request from: {{ $sittingRequest->start_date }}</h2>
                    @foreach($sittingRequest->applications as $application)
                        <a href="{{ route('applications.show', $application) }}">
                            <div>
                                <p>Sitters Name: {{ $application->sitter->name }}</p>
                                <p>Message: {{ $application->message }}</p>
                                <p>Start Date: {{ $application->sitting_request->start_date }}</p>
                                <p>End Date: {{ $application->sitting_request->end_date }}</p>
                                <p>Status: {{ $application->status }}</p>
                            </div>
                        </a>
                        <br>
                    @endforeach
                @endforeach
            @endforeach
        </div>
    @elseif($user->profile->role === 'sitter')
        <div>
            @if($user->applications->isNotEmpty())
                @foreach($user->applications as $application)
                    <div>
                        <p>Request by: {{ $application->sitting_request->pet->owner->name }}</p>
                        <p>Pet: {{ $application->sitting_request->pet->name }}</p>
                        <p>Start Date: {{ $application->sitting_request->start_date }}</p>
                        <p>End Date: {{ $application->sitting_request->end_date }}</p>
                        <p>Message: {{ $application->message }}</p>
                        <p>Status: {{ $application->status }}</p>
                        @if($application->status === 'accepted')
                            @if(!empty($application->review))
                            <p>Your rating for this request is: {{ $application->review->rating }}</p>
                            @else
                                <p>you have not been rated yet</p>
                            @endif
                        @endif
                    </div>
                    <br>
                @endforeach
            @endif
        </div>
    @endif
</x-app-layout>
