@if ($status == 'draft')
	<button type="button" data-id="{{ $itemID }}" class="edit btn bg-navy btn-flat btn-sm">Edit</button>
	<button type="button" data-id="{{ $itemID }}" class="delete btn bg-maroon btn-flat btn-sm">Delete</button>
@endif

<button type="button" data-id="{{ $itemID }}" class="view btn bg-primary btn-flat btn-sm">View</button>
@if ($status == 'published')
	<button type="button" data-id="{{ $itemID }}" class="done btn btn-success btn-flat btn-sm">Done</button>
@endif

@if ($status == 'done')
	<button type="button" data-id="{{ $itemID }}" class="view btn bg-default btn-flat btn-sm">View Results</button>
@endif




