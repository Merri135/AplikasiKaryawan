@extends('layout.app')

@section('content')

<div class="card mt-4">
    <div class="card-header bg-white text-white d-flex justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Data User</h1>
        <button class="btn btn-success btn-sm" id="btnAdd">+ Tambah User</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="userTable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="userModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="userForm">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="modalTitle">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @csrf
          <input type="hidden" id="userId">
          <div class="mb-3">
            <label>Nama</label>
            <input type="text" id="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" id="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" id="password" class="form-control">
          </div>
          <div class="mb-3">
            <label>Role</label>
            <select id="role" class="form-select" required>
              <option value="">-- Pilih Role --</option>
              <option value="karyawan">Karyawan</option>
              <option value="supervisor">Supervisor</option>
              <option value="hrd">HRD</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Tambahkan meta CSRF di <head> layout utama --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // --- Tambahkan CSRF token untuk semua request AJAX ---
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadUsers();

    function loadUsers() {
        $.get('{{ route("admin.users.ajaxList") }}', function(data) {
            let rows = '';
            $.each(data, function(i, user) {
                rows += `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.nama}</td>
                        <td>${user.email}</td>
                        <td><span class="badge bg-info text-dark">${user.role}</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning btnEdit" data-id="${user.id}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger btnDelete" data-id="${user.id}"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>`;
            });
            $('#userTable tbody').html(rows);
        });
    }

    // Tambah user
    $('#btnAdd').click(function() {
        $('#modalTitle').text('Tambah User');
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#userModal').modal('show');
    });

    // Simpan (Tambah/Edit)
    $('#userForm').submit(function(e) {
        e.preventDefault();
        const id = $('#userId').val();
        const url = id ? `/admin/users/${id}/update` : `{{ route('admin.users.ajaxStore') }}`;
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: {
                nama: $('#nama').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                role: $('#role').val()
            },
            success: function(res) {
                alert(res.message);
                $('#userModal').modal('hide');
                loadUsers();
            },
            error: function(err) {
                alert('Terjadi kesalahan: ' + (err.responseJSON?.message || 'Tidak diketahui'));
            }
        });
    });

    // Edit user
    $(document).on('click', '.btnEdit', function() {
        const id = $(this).data('id');
        $.get(`/admin/users/${id}/show`, function(user) {
            $('#modalTitle').text('Edit User');
            $('#userId').val(user.id);
            $('#nama').val(user.nama);
            $('#email').val(user.email);
            $('#password').val('');
            $('#role').val(user.role);
            $('#userModal').modal('show');
        });
    });

    // Hapus user
    $(document).on('click', '.btnDelete', function() {
        if (!confirm('Yakin ingin menghapus user ini?')) return;
        const id = $(this).data('id');

        $.ajax({
            url: `/admin/users/${id}/delete`,
            method: 'DELETE',
            success: function(res) {
                alert(res.message);
                loadUsers();
            },
            error: function(err) {
                alert('Terjadi kesalahan: ' + (err.responseJSON?.message || 'Tidak diketahui'));
            }
        });
    });
});
</script>
@endsection
