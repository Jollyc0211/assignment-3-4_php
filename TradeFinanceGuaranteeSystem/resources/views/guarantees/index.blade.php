@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">All Guarantees</h1>

    @if (session('success'))
        <div style="color: green; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('guarantees.create') }}" style="margin-bottom: 20px; display: inline-block;">+ Create New Guarantee</a>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Reference #</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Expiry</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($guarantees as $guarantee)
                <tr>
                    <td>{{ $guarantee->id }}</td>
                    <td>{{ $guarantee->corporate_reference_number }}</td>
                    <td>{{ $guarantee->guarantee_type }}</td>
                    <td>{{ $guarantee->nominal_amount }}</td>
                    <td>{{ $guarantee->nominal_amount_currency }}</td>
                    <td>{{ $guarantee->expiry_date }}</td>
                    <td>{{ $guarantee->status ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('guarantees.show', $guarantee->id) }}">View</a> |
                        <a href="{{ route('guarantees.edit', $guarantee->id) }}">Edit</a> |
                        <form action="{{ route('guarantees.destroy', $guarantee->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form> |
                        <form action="{{ url('guarantees/'.$guarantee->id.'/review') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Submit for Review</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No guarantees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
