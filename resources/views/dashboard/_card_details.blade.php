@php
    // $type and $items are provided
@endphp
<div class="p-3">
    <h5 class="mb-3 text-capitalize">{{ str_replace('-', ' ', $type) }} terbaru</h5>
    @if(empty($items) || $items->isEmpty())
        <div class="text-muted">Tidak ada data untuk ditampilkan.</div>
    @else
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        @if($type === 'pasien-baru')
                            <th>No. RM</th>
                            <th>Nama</th>
                            <th>Tanggal Daftar</th>
                        @else
                            <th>No. Daftar</th>
                            <th>Nama</th>
                            <th>Poli / Status</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $it)
                        <tr>
                            @if($type === 'pasien-baru')
                                <td>{{ $it->no_rm ?? '-' }}</td>
                                <td>{{ $it->nama ?? ($it->name ?? '-') }}</td>
                                <td>{{ optional($it->created_at)->translatedFormat('d M Y H:i') ?? '-' }}</td>
                            @else
                                <td>{{ $it->no_daftar ?? $it->id ?? '-' }}</td>
                                <td>{{ $it->nama ?? ($it->patient_name ?? '-') }}</td>
                                <td>{{ $it->poli ?? $it->status ?? '-' }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>