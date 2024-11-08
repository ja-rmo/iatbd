{{-- de profiel pagina van een huisdier, hierop zal ook de rating van het huisdier te zien zijn --}}
<x-app-layout>
    <div>
        <h2>Pet profile</h2>
    </div>
    <div>
        <div>
            {{ $pet->name }}
        </div>
        <div>
            <div>
                {{ $pet->photos }}
            </div>
        </div>

        <div>
            <div>
                {{ $pet->description }}
            </div>
        </div>
        <div>
            <div>
                {{ $pet->species }}
            </div>
        </div>
        <div>
            <div>
                {{ $pet->owner->name }}
            </div>
        </div>
        <div>
            <div>
                {{ $pet->rating }}
            </div>
        </div>
    </div>
</x-app-layout>
