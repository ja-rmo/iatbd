<x-app-layout>
    <div>
        <h2>Profiel</h2>
    </div>

    <div>
        Dit is jouw profiel, hier kan je je gegevens bekijken en bewerken.
    </div>

    {{-- form waar profile velden aangepast kunnen worden --}}
    <form method="post" action="{{ route('profile.updater', $profile) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="bio">Bio</label>
            <input id="bio" type="text" name="bio" value="{{ $profile->bio ?? old('bio')}}" />
        </div>

        <div>
            <button type="submit">
                Bewerk Bio
            </button>
        </div>
    </form>
    <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="photo">Photo</label>
            <img src="{{ Storage::url($profile->photo) }}" alt="your profile picture">
            <input id="photo" type="file" name="photo" value="" autofocus />
        </div>
        <div>
            <button type="submit">
                Bewerk foto
            </button>
        </div>
    </form>
</x-app-layout>


