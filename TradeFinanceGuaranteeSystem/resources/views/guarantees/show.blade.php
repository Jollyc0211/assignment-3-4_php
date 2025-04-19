<form action="{{ route('guarantees.review', $guarantee->id) }}" method="POST">
    @csrf
    <button class="btn btn-warning">Submit for Review</button>
</form>

<form action="{{ route('guarantees.apply', $guarantee->id) }}" method="POST">
    @csrf
    <button class="btn btn-info">Apply</button>
</form>

<form action="{{ route('guarantees.issue', $guarantee->id) }}" method="POST">
    @csrf
    <button class="btn btn-success">Issue</button>
</form>
