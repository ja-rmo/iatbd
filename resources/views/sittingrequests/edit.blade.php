<x-app-layout>
    <div>
        <h2>Edit Sitting Request</h2>
    </div>
    <div>
        <h1>Edit Sitting Request</h1>
        <form method="post" action="{{ route('sittingrequests.update', $sittingRequest) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div>
                <label for="start_date">Start Date</label>
                <input id="start_date" type="date" name="start_date" value="{{ $sittingRequest->start_date }}" required />
            </div>
            <div>
                <label for="end_date">End Date</label>
                <input id="end_date" type="date" name="end_date" value="{{ $sittingRequest->end_date }}" required />
            </div>
            <div>
                <label for="rate">Rate</label>
                <input id="rate" type="text" name="rate" value="{{ $sittingRequest->rate }}" required />
            </div>
            <div>
                <button type="submit">
                    Edit Sitting Request
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
