<x-guest-layout>
    <div>
        <h1>Welkom bij PassenOpJeDier</h1>
        <p>Vind de perfecte oppas voor jouw huisdier terwijl je weg bent. Of bied jezelf aan als oppas en verdien een extra zakcentje!</p>
        <div>
            {{-- if the route has login make the links to dashboard --}}
            <a href="{{ route('login') }}">Inloggen</a>

            <a href="{{ route('register') }}">Registreren</a>
        </div>
    </div>
</x-guest-layout>
