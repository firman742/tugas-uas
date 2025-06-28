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

            <!-- Content -->
            <div class="col-md-8">
                <section class="card">
                    <div class="bio-graph-heading bg-warning">
                        <h4>Profil</h4>
                    </div>
                    <div class="bio-graph-info">
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <strong>Nama</strong>: {{ $user->name }}
                            </div>
                            <div class="col-12 col-md-6">
                                <strong>Email</strong>: {{ $user->email }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <strong>Telepon</strong>: {{ $user->phone ?? '-' }}
                            </div>
                            <div class="col-12 col-md-6">
                                <strong>Alamat</strong>: {{ $user->address ?? '-' }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <strong>Peran</strong>: {{ ucfirst($user->role) }}
                            </div>
                            <div class="col-12 col-md-6">
                                <strong>Status</strong>:
                                @if ($user->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif

                                <!-- Tombol toggle status -->
                                @if (auth()->user()->role === 'superadmin')
                                    <button class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-primary' }} ms-2" onclick="event.preventDefault(); toggleStatus({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }})">
                                        <i class="fas fa-pen"></i>
                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <strong>Verifikasi Email</strong>:
                                @if ($user->email_verified_at)
                                    {{ $user->email_verified_at->format('d M Y') }}
                                @else
                                    Belum Diverifikasi
                                @endif
                            </div>
                            <div class="col-12 col-md-6">
                                <strong>Dibuat</strong>: {{ $user->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>

        <script>
            function toggleStatus(userId, isActive) {
                const action = isActive ? 'menonaktifkan' : 'mengaktifkan';
                if (confirm(`Apakah Anda yakin ingin ${action} akun ini?`)) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/users/${userId}/toggle-status`;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';

                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>
    @endsection
</x-app-layout>
