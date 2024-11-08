{{-- pagina om iemands huis te laten zien --}}
<x-app-layout>
    <div>
        <h2>
            Huis van {{ $house->user->name }}
        </h2>
    </div>

    <div>
        {{-- photos --}}
        <div>
            @foreach ($house->photos as $photo)
                <div>
                    <img src="{{ Storage::url($photo->url) }}" alt="House Photo" style="width: 150px; height: auto;">
                    <form method="POST" action="{{ route('houses.deletePhoto', $photo->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </div>
            @endforeach
                <img src="{{ $house->photos }}" alt="house photo">

        </div>
        <p>Adres: {{ $house->address }}</p>
        <p>Beschrijving: {{ $house->description }}</p>
    </div>
    <div>
        <form action="{{ route('houses.destroy', $house) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">
                Verwijderen
            </button>
        </form>
    </div>

</x-app-layout>
