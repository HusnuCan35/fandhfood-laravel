@extends('admin.layouts.app')

@section('page-title', 'Masa Talepleri')
@section('page-subtitle', 'Aktif garson ve hesap taleplerini yönetin')

@section('content')
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Bekleyen Talepler</h3>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Masa</th>
                    <th>Talep Tipi</th>
                    <th>Zaman</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                @forelse($calls as $call)
                    <tr>
                        <td>
                            <div
                                style="background: var(--admin-bg); padding: 8px 15px; border-radius: 10px; display: inline-block; font-weight: 700;">
                                {{ $call->table->name }}
                            </div>
                        </td>
                        <td>
                            @if($call->type == 'waiter')
                                <span class="status-badge status-preparing">
                                    <i class="las la-concierge-bell"></i> Garson Çağırıyor
                                </span>
                            @else
                                <span class="status-badge status-pending">
                                    <i class="las la-file-invoice-dollar"></i> Hesap İstiyor
                                </span>
                            @endif
                        </td>
                        <td>{{ $call->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('admin.calls.complete', $call) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="las la-check"></i> Tamamlandı
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                            <i class="las la-smile-beam" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                            Henüz bekleyen bir talep yok.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script>
            // Refresh the page every 30 seconds to update new calls
            setTimeout(function () {
                location.reload();
            }, 30000);
        </script>
    @endpush
@endsection