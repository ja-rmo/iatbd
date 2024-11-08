<x-app-layout>
    <div>
        <h2>Create Review</h2>
    </div>

    <form method="POST" action="{{ route('review.store') }}">
        @csrf
        <input type="hidden" name="application_id" value="{{ $application->id }}">

        <div>
            <label for="comment">comment</label>
            <textarea id="comment" name="comment" required></textarea>
        </div>

        <div>
            <label for="rating">Rating</label>
            <input id="rating" type="number" name="rating" min="1" max="5" required>
        </div>

        <div>
            <button type="submit">Submit Review</button>
        </div>
    </form>
</x-app-layout>
