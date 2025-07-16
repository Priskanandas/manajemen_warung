<x-app-layout>
    <x-slot name="title">Nota</x-slot>

    <style>
        @media print {
            body {
                width: 58mm;
                font-size: 11px;
                font-family: monospace;
                margin: 0;
            }

            .no-print {
                display: none;
            }

            .nota {
                width: 100%;
                padding: 10px;
            }
        }

        .nota {
            width: 300px;
            font-size: 12px;
            font-family: monospace;
            margin: 0 auto;
        }

        .nota td {
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        hr {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }
    </style>

    <div class="nota">
        <div class="text-center">
            <h4>{{ strtoupper($pembayaran->warung->nama_warung ?? 'NAMA WARUNG') }}</h4>
            <p>{{ $pembayaran->warung->alamat ?? '-' }}</p>
            <hr>
        </div>

        <p><strong>No. Nota:</strong> 00{{ $pembayaran->id }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d/m/Y H:i') }}</p>
        <p><strong>Kasir:</strong> {{ $pembayaran->pelayan->name ?? '-' }}</p>

        <hr>

        <table style="width: 100%;">
            @foreach ($pembayaran->penjualan as $item)
                <tr>
                    <td colspan="2">{{ $item->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                </tr>
                <tr>
                    <td>{{ $item->jml_beli }} x Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>

        <hr>

        <table style="width: 100%;">
            <tr>
                <td><strong>Total</strong></td>
                <td class="text-right">Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Tunai</strong></td>
                <td class="text-right">Rp {{ number_format($pembayaran->total_uang, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Kembali</strong></td>
                <td class="text-right">Rp {{ number_format($pembayaran->uang_kembali, 0, ',', '.') }}</td>
            </tr>
        </table>

        <hr>

        <div class="text-center">
            <p>Terima Kasih</p>
            <p>~ Surya POS ~</p>
        </div>

        <div class="text-center mt-3 no-print">
            <button onclick="window.print()" class="btn btn-sm btn-primary">🖨️ Cetak</button>
            <a href="{{ route('admin.pembayaran') }}" class="btn btn-sm btn-secondary">Kembali</a>
        </div>
    </div>
</x-app-layout>
