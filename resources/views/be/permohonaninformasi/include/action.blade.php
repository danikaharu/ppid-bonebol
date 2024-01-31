@role('user')
    <form action="{{ route('admin.permohonaninformasi.destroy', $item->id) }}" method="post"
        onsubmit="return confirm('Yakin menghapus data permohonan ini?')">
        @csrf
        @method('delete')
        <div class="d-flex justify-content-center align-items-center gap-1">
            <a href="{{ route('admin.permohonaninformasi.show', $item->id) }}" class="btn btn-dark icon">
                <i data-feather="eye" width="20"></i>
            </a>
            @if ($item->status == 0)
                <a href="{{ route('admin.permohonaninformasi.edit', $item->id) }}" class="btn btn-warning icon">
                    <i data-feather="edit" width="20"></i>
                </a>
                <button type="submit" class="btn btn-danger btn-sm icon">
                    <i data-feather="trash" width="20"></i>
                </button>
            @elseif($item->status == 2)
                <button type="submit" class="btn btn-danger btn-sm icon">
                    <i data-feather="trash" width="20"></i>
                </button>
            @elseif($item->status == 3)
                <button type="submit" class="btn btn-danger btn-sm icon">
                    <i data-feather="trash" width="20"></i>
                </button>
            @endif

        </div>
    </form>
@endrole
@role('admin')
    <form action="{{ route('admin.permohonaninformasi.destroy', $item->id) }}" method="post"
        onsubmit="return confirm('Yakin menghapus data permohonan ini?')">
        @csrf
        @method('delete')
        <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
            @if ($item->status == 0)
                <a href="{{ route('admin.permohonaninformasi.proses', $item->id) }}" class="btn btn-primary icon"
                    onclick="return confirm('Yakin memproses permohonan ini?')">
                    <i data-feather="arrow-right" width="20"></i> Proses
                </a>
            @elseif($item->status == 4)
                <a href="{{ route('admin.pengajuankeberatan.show', $item->pengajuankeberatan->id) }}"
                    class="btn bg-info text-white icon">
                    <i data-feather="arrow-right" width="20"></i> Proses
                </a>
            @else
                <a href="{{ route('admin.permohonaninformasi.show', $item->id) }}" class="btn btn-dark icon">
                    <i data-feather="eye" width="20"></i>
                </a>
            @endif
            <a href="{{ route('admin.permohonaninformasi.edit', $item->id) }}" class="btn btn-warning icon">
                <i data-feather="edit" width="20"></i>
            </a>
            <button type="submit" class="btn btn-danger btn-sm icon">
                <i data-feather="trash" width="20"></i>
            </button>
        </div>
    </form>
@endrole
@role('petugas')
    @if ($item->status == 0)
        <a href="{{ route('admin.permohonaninformasi.proses', $item->id) }}" class="btn btn-primary icon"
            onclick="return confirm('Yakin memproses permohonan ini?')">
            <i data-feather="arrow-right" width="20"></i> Proses
        </a>
    @elseif($item->status == 4)
        <a href="{{ route('petugas.pengajuankeberatan.show', $item->pengajuankeberatan->id) }}"
            class="btn bg-info text-white icon">
            <i data-feather="arrow-right" width="20"></i> Proses
        </a>
    @else
        <a href="{{ route('admin.permohonaninformasi.show', $item->id) }}" class="btn btn-dark icon">
            <i data-feather="eye" width="20"></i>
        </a>
    @endif
@endrole
