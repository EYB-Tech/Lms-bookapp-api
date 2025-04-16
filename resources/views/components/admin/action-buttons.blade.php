<div class="btn-group">
    <a class="btn btn-sm btn-alt-secondary" href="{{ route($route . '.edit', $id) }}" data-bs-toggle="tooltip"
        title="{{ __('Edit') }}">
        <i class="fa fa-fw fa-edit"></i>
    </a>
    <a class="btn btn-sm btn-sm btn-alt-secondary" href="javascript:void(0)"
        onclick="event.preventDefault(); 
   if (confirm('{{ __('Are you sure?') }}')) {
       document.getElementById('delete-form-{{ $route . $id }}').submit();
   }"
        data-bs-toggle="tooltip" title="{{ __('Delete') }}">
        <i class="fa fa-fw fa-times"></i>
    </a>
    <form action="{{ route($route . '.destroy', $id) }}" id="delete-form-{{ $route . $id }}" method="post"
        style="display: none;">
        @csrf
        @method('delete')
    </form>
</div>
