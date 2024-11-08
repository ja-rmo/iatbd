<x-app-layout>
    <div>
        <h1>Create Sitting Request</h1>
        <form method="post" action="{{ route('sittingrequests.store') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="pet_id">Pet</label>
                <select id="pet_id" name="pet_id" required>
                    @foreach($pets as $pet)
                        <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="start_date">Start Date</label>
                <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}" required />
            </div>
            <div>
                <label for="end_date">End Date</label>
                <input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}" required />
            </div>
            <div>
                <label for="rate">Rate</label>
                <input id="rate" type="number" step="0.01" name="rate" value="{{ old('rate') }}" required />
            </div>
            <div>
                <label for="message">Message</label>
                <textarea id="message" name="message" required>{{ old('message') }}</textarea>
            </div>
            <div>
                <button type="submit">Create Sitting Request</button>
            </div>
        </form>
    </div>
</x-app-layout>
