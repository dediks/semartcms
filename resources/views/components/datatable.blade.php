@push('css-plugins')
	@include('layouts.datatables_css')
@endpush

@push('js-plugins')
	@include('layouts.datatables_js')
@endpush

@isset($dataTable)
@push('scripts')
	{{ $dataTable->scripts() }}
@endpush
@endisset