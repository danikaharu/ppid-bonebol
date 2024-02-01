@can('edit classification')
    <a href={{ route('admin.klasifikasi.edit', $klasifikasi->id) }} class="btn
btn-warning icon">
        <i data-feather="edit" width="20"></i>
    </a>
@endcan

@can('delete classification')
    <form action={{ route('admin.klasifikasi.destroy', $klasifikasi->id) }} method="post"
        onsubmit = "return confirm('Yakin ingin menghapus data ini?')">
        @csrf
        @method('delete')

        <button type="submit" class="btn btn-danger btn-sm icon">
            <i data-feather="trash" width="20"></i>
        </button>
    </form>
@endcan
