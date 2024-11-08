<x-app-layout>
    <div>
        <h1>Users</h1>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if(!$user->blocked)
                            <form method="POST" action="{{ route('admin.blockUser', $user) }}">
                                @csrf
                                @method('put')
                                <button type="submit">Block</button>
                            </form>
                        @else
                            <form action="{{ route('admin.unblockUser', $user) }}" method="post">
                                @csrf
                                @method('put')
                                <button type="submit">Unblock</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <div>
        <h1>Sitting Requests</h1>
        <table>
            <thead>
            <tr>
                <th>Pet</th>
                <th>Owner</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Rate</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sittingRequests as $sittingRequest)
                <tr>
                    <td>{{ $sittingRequest->pet->name }}</td>
                    <td>{{ $sittingRequest->pet->owner->name }}</td>
                    <td>{{ $sittingRequest->start_date }}</td>
                    <td>{{ $sittingRequest->end_date }}</td>
                    <td>{{ $sittingRequest->rate }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.deleteRequest', $sittingRequest) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
