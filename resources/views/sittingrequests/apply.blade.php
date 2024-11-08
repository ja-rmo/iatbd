{{-- pagina om alle details van het verzoek te bekijken en als oppas jezelf aan te bieden --}}
<x-app-layout>
    <div>
        <h2>
            Verzoek van {{ $sittingRequest->user->name }}
        </h2>
    </div>

    <div>
        <h1>Verzoek van {{ $sittingRequest->user->name }}</h1>
        <p>Huisdier: {{ $sittingRequest->pet->name }}</p>
        <p>Van: {{ $sittingRequest->start_date }} tot {{ $sittingRequest->end_date }}</p>
        <p>Bericht: {{ $sittingRequest->message }}</p>
        <p>Tarief: €{{ $sittingRequest->rate }}</p>
        <a href="{{ route('users.show', $sittingRequest->user) }}">Profiel van {{ $sittingRequest->user->name }}</a>
        <form action="{{ route('sittingrequest.apply', $sittingRequest) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="pending">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <button type="submit">Aanmelden</button>
        </form>
    </div>
</x-app-layout>
