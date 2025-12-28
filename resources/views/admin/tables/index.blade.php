@extends('admin.layouts.app')

@section('page-title', 'Masa Yönetimi')
@section('page-subtitle', 'Restoran masalarını yönetin')

@section('content')
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Masalar</h3>
            <a href="{{ route('admin.tables.create') }}" class="btn btn-primary btn-sm">
                <i class="las la-plus"></i> Yeni Masa Ekle
            </a>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Masa Adı</th>
                        <th>Durum</th>
                        <th>QR Link</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tables as $table)
                        <tr>
                            <td>#{{ $table->id }}</td>
                            <td>{{ $table->name }}</td>
                            <td>
                                @if($table->status)
                                    <span class="badge badge-success"
                                        style="color: green; background: #e6fffa; padding: 5px 10px; border-radius: 15px;">Aktif</span>
                                @else
                                    <span class="badge badge-danger"
                                        style="color: red; background: #fff5f5; padding: 5px 10px; border-radius: 15px;">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('qrmenu.index', ['table' => $table->id]) }}" target="_blank"
                                    style="color: var(--admin-primary); text-decoration: underline;">
                                    {{ route('qrmenu.index', ['table' => $table->id]) }}
                                </a>
                            </td>
                            <td>
                                <div style="display: flex; gap: 10px;">
                                    <a href="{{ route('admin.tables.edit', $table) }}" class="btn btn-sm btn-info"
                                        title="Düzenle">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.tables.destroy', $table) }}" method="POST"
                                        onsubmit="return confirm('Bu masayı silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Sil">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: #888;">
                                Henüz masa eklenmemiş.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection