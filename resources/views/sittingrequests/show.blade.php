{{-- deze pagina is gemaakt om de een verzoek in zn totaliteit te laten zien en erop te kunnen reageren als oppas--}}
<x-app-layout>
    <div>
        <h2>
            Verzoek van {{ $sittingRequest->pet->owner->name }}
        </h2>
    </div>

    <div>
        <h1>Request by: {{ $sittingRequest->pet->name }}</h1>
        <p>Pet: {{ $sittingRequest->pet->name }}</p>
        <p>start date: {{ $sittingRequest->start_date }}</p>
        <p>end date: {{ $sittingRequest->end_date }}</p>
        <p>message: {{ $sittingRequest->message }}</p>
        <p>rate: {{ $sittingRequest->rate }}</p>
    </div>
    <div>
        <h2>Apply for this request</h2>
        <form method="post" action="{{ route('applications.apply') }}" enctype="multipart/form-data">
            @csrf
            <label for="message">Message</label>
            <input id="message" type="text" name="message" value="" required>
            <input id="sittingRequest" type="hidden" name="sittingRequest" value="{{ $sittingRequest->id }}" required>
            <button type="submit">
                Apply
            </button>
        </form>
    </div>
</x-app-layout>
