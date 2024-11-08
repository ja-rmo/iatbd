{{-- pagina om het huisdier te kunnen bewerken --}}
<x-app-layout>
    <div>
        <h2>
            Edit pet
        </h2>
    </div>


    <div>
        <form method="POST" action="{{ route('pets.update', $pet) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ $pet->name }}" required autofocus />
            </div>

            <div>
                <label for="species">Species</label>
                <input id="species" type="text" name="species" value="{{ $pet->species }}" required />
            </div>

            <div>
                <label for="description">Description</label>
                <input id="description" type="text" name="description" value="{{ $pet->description }}" required/>
            </div>
            <div>
                <label for="photo">Photo</label>
                @if(!empty($pet->photo))
                    <p>Current photo:</p>
                    <img src="{{ Storage::url($pet->photo) }}" alt="Current photo of {{ $pet->name }}" style="width: 150px; height: auto;">
                @endif
                <input id="photo" type="file" name="photo" value="" required />
            </div>
            <div>
                <button type="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
