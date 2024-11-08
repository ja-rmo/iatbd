<!--  pagina om huis aan te maken -->
<x-app-layout>
        <div>
            <h2>
            Huis aanmaken
        </h2>
        </div>

    <div>
        <form method="POST" action="{{ route('houses.store') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="address">address</label>
                <input id="address" type="text" name="address" value="" required autofocus />
            </div>

            <div>
                <label for="description">description</label>
                <input id="description" type="text" name="description" value="" required />
            </div>

            <div>
                <label for="photos">Photos, up to 5</label>
                <input id="photos" type="file" name="photos[]" value="" multiple />
                @error('photos')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit">
                    Aanmaken
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
