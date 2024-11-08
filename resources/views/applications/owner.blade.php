<x-app-layout>
    <div>
        <p>Application from {{ $application->sitter->name }}</p>
        <form method="post" action="{{ route('applications.update', $application) }}">
            @csrf
            @method('PUT')
            <input id="status" name="status" type="hidden" value="accepted">
            <button type="submit">Accept</button>
        </form>
        <form method="post" action="{{ route('applications.update', $application) }}">
            @csrf
            @method('PUT')
            <input id="status" name="status" type="hidden" value="rejected">
            <button type="submit">Reject</button>
        </form>
        <p>Message: {{ $application->message }}</p>
        <p>sitters house address: {{ $application->sitter->house->address }}</p>
        @if(!empty($application->sitter->house->photos ))
            <p>photo of sitters house</p>
            @foreach($application->sitter->house->photos as $photo)
                <img src="{{ Storage::url($photo->url) }}" alt="">
            @endforeach
        @endif
    </div>
</x-app-layout>
