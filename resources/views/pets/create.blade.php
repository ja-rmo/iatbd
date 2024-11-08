<x-app-layout>
    <div>
        <h2>
            Huisdier aanmaken
        </h2>
    </div>
    <div>
        <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="name">Name</label>
                <input id="name" type="text" name="name" required autofocus />
            </div>
            <div>
                <label for="species">Species</label>
                <input id="species" type="text" name="species" required />
            </div>
            <div>
                <label for="description">Description</label>
                <input id="description" type="text" name="description" required />
            </div>
            <div>
                <label for="photo">Photo</label>
                <input id="photo" type="file" name="photo" />
            </div>
            <div>
                <button type="submit">
                    Create pet
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
