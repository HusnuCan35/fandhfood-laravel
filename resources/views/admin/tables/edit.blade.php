@extends('admin.layouts.app')

@section('page-title', 'Masayı Düzenle')
@section('page-subtitle', 'Masa bilgilerini güncelleyin')

@section('content')
    <div class="admin-card" style="max-width: 600px;">
        <div class="card-header">
            <h3 class="card-title">Masa Bilgileri</h3>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary btn-sm">
                <i class="las la-arrow-left"></i> Geri Dön
            </a>
        </div>

        <form action="{{ route('admin.tables.update', $table) }}" method="POST" style="padding: 20px;">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600;">Masa Adı</label>
                <input type="text" name="name" id="name" value="{{ old('name', $table->name) }}" class="form-control"
                    required placeholder="Örn: Masa 1, Teras 3"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                @error('name')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="status" value="1" {{ $table->status ? 'checked' : '' }}
                        style="width: 18px; height: 18px;">
                    <span>Aktif</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary"
                style="padding: 10px 20px; background: var(--admin-primary); color: white; border: none; border-radius: 8px; cursor: pointer;">
                <i class="las la-save"></i> Güncelle
            </button>
        </form>
    </div>
@endsection