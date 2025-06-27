<x-app-layout>
    @section('content')
        <div class="row my-5">
            <!-- Sidebar -->
            <div class="col-md-4 mb-3">
                <div class="profile-sidebar bg-warning">
                    <img src="{{ $user->profile_photo
                            ? asset('storage/profile_photos/' . $user->profile_photo)
                            : asset('img/undraw_profile.svg') }}"
                         alt="Foto Profil">
                    <h4 class="text-white">{{ $user->name }}</h4>
                    <p class="text-white">{{ $user->email }}</p>

                    <hr>
                    <div class="list-group text-start">
                        <a href="{{ route('users.show', $user->id) }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('users.show') ? 'active' : '' }}">
                            <i class="bi bi-person"></i> Profil
                        </a>

                        <a href="{{ route('users.edit', $user->id) }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('users.edit') ? 'active' : '' }}">
                            <i class="bi bi-pencil-square"></i> Edit Profil
                        </a>

                        <a href="{{ route('users.index') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <i class="bi bi-arrow-left-circle"></i> Kembali ke Menu
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Edit -->
            <div class="col-md-8">
                <section class="card">
                    <div class="bio-graph-heading bg-warning">
                        Perbarui informasi pengguna di bawah ini
                    </div>
                    <div class="bio-graph-form">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address', $user->address) }}">
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="pengguna" {{ old('role', $user->role) == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status Aktif</label>
                                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-start mt-4">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    @endsection
</x-app-layout>
