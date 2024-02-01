<form action={{ route('admin.role.destroy', $role->id) }} method="post"
    onsubmit = "return confirm('Yakin Ingin Menghapus Role ?')">
    @csrf
    @method('delete')
    <a href={{ route('admin.role.edit', $role->id) }} class="btn btn-warning icon">
        <i data-feather="edit" width="20"></i>
    </a>
    <button type="submit" class="btn btn-danger btn-sm icon">
        <i data-feather="trash" width="20"></i>
    </button>
</form>
