{{-- file should display a list of all pets the user has created --}}
<x-app-layout>
	<div>
		<ul>
			@foreach ($pets as $pet)
                <a href="{{ route('pets.edit', $pet->id) }}">
				<li>{{ $pet->name }}</li>
                @if(!empty($pet->photo))
                    <li><img src="{{ Storage::url($pet->photo) }}" alt="Picture of {{ $pet->name }}" style="width: 150px; height: auto;"></li>
                @endif
                <li><p>Species: {{ $pet->species }}</p></li>
                </a>
			@endforeach
		</ul>
	</div>
</x-app-layout>
