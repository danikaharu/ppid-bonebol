@can('show information')
    <a href={{ route('admin.infopub.show', $informasi->id) }} class="btn btn-dark icon">
        <i data-feather="eye" width="20"></i>
    </a>
@endcan

@can('edit information')
    <a href={{ route('admin.infopub.edit', $informasi->id) }} class="btn btn-warning icon">
        <i data-feather="edit" width="20"></i>
    </a>
@endcan

@can('delete information')
    <form action={{ route('admin.infopub.destroy', $informasi->id) }} method="post"
        onsubmit = "return confirm('Yakin Ingin Menghapus Informasi ?')">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm icon">
            <i data-feather="trash" width="20"></i>
        </button>
    </form>
@endcan
