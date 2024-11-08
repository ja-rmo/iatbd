<x-app-layout>
        @if($user->profile->role === 'sitter')
    <div>
        <h2>Filter requests</h2>
        <form method="get" action="{{ route('sittingrequests.index') }}" enctype="multipart/form-data">
            <div>
                <label for="rate">Minimal rate</label>
                <input id="rate" type="number" name="rate" value="{{ request('rate') }}">
            </div>
            <div>
                <label for="start_date">Start date</label>
                <input id="start_date" type="date" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div>
                <label for="end_date">End date</label>
                <input id="end_date" type="date" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div>
                <button type="submit">Filter</button>
            </div>
        </form>
    </div>

    <div>
        @foreach($requests as $request)
            <div>
                <a href="{{ route('sittingrequests.show', $request) }}">
                    <p>Request by: {{ $request->pet->owner->name }}</p>
                    <p>Request for: {{ $request->pet->name }}</p>
                    @if(!empty($request->pet->photo))
                        <img src="{{ Storage::url($request->pet->photo) }}" alt="Photo of {{ $request->pet->name }}">
                    @endif
                    <p>Rate: {{ $request->rate }}</p>
                    <p>Start Date: {{ $request->start_date }}</p>
                    <p>End Date: {{ $request->end_date }}</p>
                    <p>Message: {{ $request->message }}</p>
                </a>
            </div>
            <br>
        @endforeach
    </div>
    @elseif($user->profile->role === 'owner')
        @foreach($requests as $request)
            <p>Request for: {{ $request->pet->name }}</p>
            @if(!empty($request->pet->photo))
                <img src="{{ Storage::url($request->pet->photo) }}" alt="Photo of {{ $request->pet->name }}">
            @endif
            <p>Rate: {{ $request->rate }}</p>
            <p>Start Date: {{ $request->start_date }}</p>
            <p>End Date: {{ $request->end_date }}</p>
            <p>Message: {{ $request->message }}</p>
        @endforeach
    @endif
</x-app-layout>
