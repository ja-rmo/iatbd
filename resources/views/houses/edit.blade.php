{{-- pagina om je eigen huis te bewerken, foto's toevoegen oid --}}
<x-app-layout>
    <div>
        <h2>Bewerk je huis</h2>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <form method="POST" action="{{ route('houses.update', $house) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="address">Address</label>
                <input id="address" type="text" name="address" value="{{ $house->address }}" required autofocus />
            </div>
            <div>
                <label for="photos">Photos</label>
                <input id="photos" type="file" name="photos[]" value="" multiple />
            </div>

            <div>
                <label for="description">Description</label>
                <input id="description" type="text" name="description" value="{{ $house->description }}" />
            </div>
            <div>
                <button type="submit">
                    Bewerken
                </button>
            </div>
        </form>

        @foreach ($photos as $photo)
            <div>
                <img src="{{ Storage::url($photo->url) }}" alt="House Photo" style="width: 150px; height: auto;">
                <form method="POST" action="{{ route('houses.deletePhoto', $photo->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete photo</button>
                </form>
            </div>
        @endforeach

        <form method="POST" action="{{ route('houses.destroy', $house) }}">
            @csrf
            @method('DELETE')
            <button type="submit">DELETE HOUSE</button>
        </form>
    </div>
</x-app-layout>
