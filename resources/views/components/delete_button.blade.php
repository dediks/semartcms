<div class="d-inline-flex">
    <a class="btn btn-danger {{ $size ?? ''}}" href="#" data-confirm="Delete {{ $kind ?? 'Record' }}|This action cannot be undone. Do you want to continue?" data-confirm-text-yes="Yes, delete it!" data-confirm-yes="$('#form-delete-{{$id}}').submit()">
    {{ $slot }}
    </a>
    <form id="form-delete-{{$id}}" method="post" action="{{ $route }}" style="visibility: hidden;">
        @csrf
        @method('delete')
    </form>
</div>
