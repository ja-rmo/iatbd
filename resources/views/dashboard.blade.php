<x-app-layout>
    <div>
        <h2>
            Dashboard
        </h2>
    </div>

    <div>
        @if ($user->profile->role === 'unset')
            <p>Please set your account as either a</p>
            <form method="post" action="{{ route('profile.updater', $user->profile) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="role" id="role" value="sitter">
                <button type="submit">Sitter</button>
            </form>
            <p>or a</p>
            <form method="post" action="{{ route('profile.updater', $user->profile) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="role" id="role" value="owner">
                <button type="submit">Owner</button>
            </form>

        @elseif ($user->profile->role === 'sitter')

            <div>
            @if($user->house)
            <a href="{{ route('houses.edit', $user->house) }}">Edit your house</a>
            @else
            <a href="{{ route('houses.create')  }}">create your house</a>
            @endif
            </div>
        <div>
            <a href="{{ route('sittingrequests.index') }}">View open pet sitting requests</a>
        </div>
        <div>
            <a href="{{ route('applications.index') }}">View your applications</a>
        </div>

        @elseif ($user->profile->role === 'owner')
            <div><a href="{{ route('pets.create') }}">Create a pet</a></div>
            <div><a href="{{ route('pets.index') }}">View your pets</a></div>
            <div><a href="{{ route('applications.index') }}">View the applications for your sitting requests</a></div>
            <div><a href="{{ route('sittingrequests.index') }}">view all your requests</a></div>
            <div><a href="{{ route('sittingrequests.create') }}">Create a sitting request</a></div>
        @endif
    </div>
</x-app-layout>
