@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-cog me-2 text-primary"></i>Pengaturan</h2>
            <p class="text-muted mb-0">Kelola pengguna aplikasi</p>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
                <i class="fas fa-users me-2"></i>Manajemen Pengguna
            </button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="settingsTabsContent">
        <!-- Users Tab -->
        <div class="tab-pane fade show active" id="users" role="tabpanel">
            <div class="card disaster-table-card shadow-sm border-0 mb-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Daftar Pengguna</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus-circle me-1"></i>Tambah Pengguna
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role">
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="addUserSubmit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm">
                <input type="hidden" name="id" id="editUserId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <small class="text-muted">(kosongkan jika tidak diganti)</small></label>
                        <input type="password" class="form-control" name="password" id="editPassword" placeholder="Isi untuk mengganti password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" id="editRole">
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="editUserSubmit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const usersEndpoint = '{{ url('/users') }}';
let usersCache = [];

document.addEventListener('DOMContentLoaded', function() {
    loadUsers();

    const addForm = document.getElementById('addUserForm');
    const editForm = document.getElementById('editUserForm');

    addForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        await createUser(new FormData(addForm));
    });

    editForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('editUserId').value;
        await updateUser(id, new FormData(editForm));
    });
});

function setButtonLoading(button, isLoading, text = 'Simpan') {
    if (!button) return;
    button.disabled = isLoading;
    button.innerHTML = isLoading ? '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...' : text;
}

async function createUser(formData) {
    const submitBtn = document.getElementById('addUserSubmit');
    setButtonLoading(submitBtn, true);

    try {
        const res = await fetch(usersEndpoint, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        });

        const data = await res.json();
        if (!res.ok) throw data;

        bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
        document.getElementById('addUserForm').reset();
        await loadUsers();
        alert(data.message || 'Pengguna berhasil ditambahkan');
    } catch (err) {
        handleError(err);
    } finally {
        setButtonLoading(submitBtn, false);
    }
}

async function loadUsers() {
    try {
        const res = await fetch(usersEndpoint, { headers: { 'Accept': 'application/json' } });
        const data = await res.json();
        if (!res.ok) throw data;

        usersCache = data.users || [];
        const tbody = document.getElementById('usersTableBody');
        if (usersCache.length > 0) {
            tbody.innerHTML = usersCache.map(user => `
                <tr>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td><span class="badge bg-primary">${user.role || 'petugas'}</span></td>
                    <td><span class="badge bg-success">Aktif</span></td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-warning me-1" onclick="openEditUser(${user.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Belum ada data pengguna</td></tr>';
        }
    } catch (err) {
        console.error('Gagal memuat pengguna:', err);
        document.getElementById('usersTableBody').innerHTML = '<tr><td colspan="5" class="text-center text-danger">Gagal memuat data</td></tr>';
    }
}

function openEditUser(id) {
    const user = usersCache.find(u => u.id === id);
    if (!user) {
        alert('Data pengguna tidak ditemukan');
        return;
    }

    document.getElementById('editUserId').value = user.id;
    document.getElementById('editName').value = user.name;
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editPassword').value = '';
    document.getElementById('editRole').value = user.role || 'petugas';

    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    modal.show();
}

async function updateUser(id, formData) {
    const submitBtn = document.getElementById('editUserSubmit');
    setButtonLoading(submitBtn, true);

    try {
        const res = await fetch(`${usersEndpoint}/${id}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData,
        });

        const data = await res.json();
        if (!res.ok) throw data;

        bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
        await loadUsers();
        alert(data.message || 'Pengguna berhasil diperbarui');
    } catch (err) {
        handleError(err);
    } finally {
        setButtonLoading(submitBtn, false);
    }
}

async function deleteUser(id) {
    if (!confirm('Yakin ingin menghapus pengguna ini?')) return;

    try {
        const res = await fetch(`${usersEndpoint}/${id}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'DELETE'
            }
        });

        const data = await res.json();
        if (!res.ok) throw data;

        await loadUsers();
        alert(data.message || 'Pengguna berhasil dihapus');
    } catch (err) {
        handleError(err);
    }
}

function handleError(err) {
    if (err && err.errors) {
        const first = Object.values(err.errors)[0];
        alert(first);
    } else if (err && err.message) {
        alert(err.message);
    } else {
        alert('Terjadi kesalahan. Silakan coba lagi.');
    }
}
</script>
@endpush
@endsection
