@extends('admin.layouts.app')

@section('page-title', 'Kullanıcılar')
@section('page-subtitle', 'Kayıtlı kullanıcıları yönetin')

@section('content')
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Kullanıcı Listesi ({{ $users->total() }})</h3>
            <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="search" class="form-input" style="width: 250px;" placeholder="Ad veya email ara..."
                    value="{{ request('search') }}">
                <select name="admin" class="form-input" style="width: auto;" onchange="this.form.submit()">
                    <option value="">Tüm Kullanıcılar</option>
                    <option value="1" {{ request('admin') === '1' ? 'selected' : '' }}>Sadece Adminler</option>
                    <option value="0" {{ request('admin') === '0' ? 'selected' : '' }}>Normal Kullanıcılar</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="las la-search"></i>
                </button>
            </form>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kullanıcı</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Siparişler</th>
                    <th>Kayıt Tarihi</th>
                    <th>Yetki</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div
                                    style="width: 45px; height: 45px; border-radius: 12px; background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            <span style="background: var(--admin-bg); padding: 6px 12px; border-radius: 20px;">
                                {{ $user->orders_count }} sipariş
                            </span>
                        </td>
                        <td style="color: var(--admin-text-light);">{{ $user->created_at->format('d.m.Y') }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="status-badge status-completed">
                                    <i class="las la-shield-alt"></i> Admin
                                </span>
                            @else
                                <span class="status-badge status-pending">
                                    <i class="las la-user"></i> Kullanıcı
                                </span>
                            @endif
                            @if($user->is_banned)
                                <span class="status-badge status-cancelled" style="margin-left: 5px;">
                                    <i class="las la-ban"></i> Yasaklı
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary btn-sm">
                                    <i class="las la-eye"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm {{ $user->is_admin ? 'btn-danger' : 'btn-primary' }}"
                                            onclick="return confirm('{{ $user->is_admin ? 'Admin yetkisini kaldırmak' : 'Admin yetkisi vermek' }} istediğinize emin misiniz?')">
                                            <i class="las la-{{ $user->is_admin ? 'user-minus' : 'user-shield' }}"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                            <i class="las la-users" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                            Kullanıcı bulunamadı
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection