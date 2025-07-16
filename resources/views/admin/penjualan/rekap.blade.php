<x-app-layout>
    <x-slot name="title">Rekap Penjualan</x-slot>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                font-family: monospace;
                font-size: 11px;
                margin: 0;
            }

            .laporan {
                padding: 10px;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid #000;
                padding: 4px;
            }
        }
    </style>

    <div class="laporan">
        <div class="text-center mb-3">
            <h5>{{ strtoupper($warung->nama_warung ?? 'NAMA WARUNG') }}</h5>
            <p>{{ $warung->alamat ?? 'Alamat tidak tersedia' }}</p>
            <p><strong>Rekap Penjualan</strong></p>
            @if(request('tanggal_awal') && request('tanggal_akhir'))
                <p><small>Periode: {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}</small></p>
            @endif
        </div>

        <div class="no-print mb-2">
            <x-card>
                <x-slot name="title">Filter Data</x-slot>
                <form method="GET" action="{{ route('admin.penjualan.rekap') }}" class="form-inline">
                    <div class="form-group mr-2">
                        <label for="tanggal_awal" class="mr-1">Dari:</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                    </div>
                    <div class="form-group mr-2">
                        <label for="tanggal_akhir" class="mr-1">Sampai:</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button onclick="window.print()" type="button" class="btn btn-info ml-2">🖨️ Cetak</button>
                </form>
            </x-card>
        </div>

        <table class="table table-bordered mt-3">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Harga Jual</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualan as $index => $item)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $item->jml_beli }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td class="text-right">Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-right">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data penjualan.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total</th>
                    <th colspan="2" class="text-right">Rp{{ number_format($total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</x-app-layout>
