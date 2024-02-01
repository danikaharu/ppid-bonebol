<form action="{{ route('admin.pengajuankeberatan.destroy', $item->id) }}" method="post"
    onsubmit="return confirm('Yakin menghapus data permohonan ini?')">
    @csrf
    @method('delete')
    <div class="d-flex justify-content-center align-items-center gap-1">
        <a href="{{ route('admin.pengajuankeberatan.show', $item->id) }}" class="btn btn-dark icon">
            <i data-feather="eye" width="20"></i>
        </a>
        @if ($item->status == 0)
            <a href="{{ route('admin.pengajuankeberatan.edit', $item->id) }}" class="btn btn-warning icon">
                <i data-feather="edit" width="20"></i>
            </a>
            <button type="submit" class="btn btn-danger btn-sm icon">
                <i data-feather="trash" width="20"></i>
            </button>
        @endif
    </div>
</form>
