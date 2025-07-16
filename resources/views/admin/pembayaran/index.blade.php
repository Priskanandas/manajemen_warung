<x-app-layout>
    <x-slot name="title">Pembayaran</x-slot>

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <x-card>
        <x-slot name="title">Form Pembayaran</x-slot>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form id="form-transaksi" action="{{ route('admin.pembayaran.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="cari_barang">Cari Barang (Nama/Kode/Scan)</label>
                    <input type="text" id="cari_barang" class="form-control" placeholder="Ketik atau scan...">
                    <div id="suggestions" class="list-group position-absolute w-100"></div>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered" id="tabel-barang">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga Jual</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="kosong">
                            <td colspan="5" class="text-center">Belum ada barang.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group mt-3">
                <label>Total Bayar</label>
                <input type="number" name="total_bayar" id="total_bayar" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Total Uang</label>
                <input type="number" name="total_uang" id="total_uang" class="form-control">
            </div>

            <div class="form-group">
                <label>Kembalian</label>
                <input type="text" id="uang_kembali" name="uang_kembali" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-success">Simpan Transaksi</button>
        </form>
    </x-card>

    <x-slot name="script">
<script>
    $(function () {
        const suggestionBox = $('#suggestions');

        // 🔍 Auto-suggest pencarian barang
        $('#cari_barang').on('input', function () {
            const keyword = $(this).val().trim();
            if (!keyword) return suggestionBox.empty();

            $.get("{{ route('admin.pembayaran.cari-barang') }}", { keyword }, function (data) {
                suggestionBox.empty();

                if (data.length === 0) {
                    suggestionBox.append('<div class="list-group-item">Tidak ditemukan</div>');
                    return;
                }

                data.forEach(barang => {
                    const harga = parseInt(barang.harga_jual) || 0;
                    const kd = barang.kd_barang ?? '-';
                    const stok = parseInt(barang.stok) || 0;

                    const stokBadge = stok <= 0
                        ? `<span class="badge badge-danger ml-2">Stok Habis</span>`
                        : stok <= 5
                            ? `<span class="badge badge-warning ml-2">Stok: ${stok}</span>`
                            : `<span class="badge badge-success ml-2">Stok: ${stok}</span>`;
                    suggestionBox.append(`
                        <button type="button" class="list-group-item list-group-item-action"
                            data-id="${barang.id}"
                            data-nama="${barang.nama_barang}"
                            data-kd="${kd}"
                            data-harga="${harga}"
                            data-stok="${stok}">
                            ${kd} - ${barang.nama_barang} ${stokBadge}
                        </button>
                    `);
                });
            }).fail(xhr => console.error("Error:", xhr.responseText));
        });

        // ➕ Tambahkan barang ke tabel
        suggestionBox.on('click', 'button', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const kd = $(this).data('kd');
            const harga = parseInt($(this).data('harga')) || 0;

            const rowId = `row-${id}`;
            const $existingRow = $(`#${rowId}`);
            const stok = parseInt($(this).attr('data-stok')) || 0;
           
            if (stok <= 0) {
                alert('Stok barang ini habis dan tidak bisa ditambahkan.');
                return;
            }
            if ($existingRow.length) {
                const qtyInput = $existingRow.find('.qty');
                qtyInput.val(parseInt(qtyInput.val()) + 1).trigger('input');
                return;
            }

            $('#kosong').remove();
            $('#tabel-barang tbody').append(`
                <tr id="${rowId}" data-id="${id}" data-harga="${harga}">
                    <td>
                        ${nama} <small class="text-muted">(${kd})</small>
                        <input type="hidden" name="id_barang[]" value="${id}">
                        <input type="hidden" name="kd_barang[]" value="${kd}">
                    </td>
                    <td>
                        Rp. ${harga.toLocaleString()}
                        <input type="hidden" name="harga_jual[]" value="${harga}">
                    </td>
                    <td>
                        <input type="number" name="jml_beli[]" class="form-control qty" min="1" value="1">
                    </td>
                    <td class="total-per-item">
                        <span class="display-total">Rp. ${harga.toLocaleString()}</span>
                        <input type="hidden" name="total_harga[]" value="${harga}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm hapus-barang">X</button>
                    </td>
                </tr>
            `);``


            $('#cari_barang').val('');
            suggestionBox.empty();
            hitungTotal();
        });

        // 🔁 Hitung total per barang saat qty berubah
        $(document).on('input', '.qty', function () {
            const row = $(this).closest('tr');
            const harga = parseInt(row.data('harga')) || 0;
            const qty = parseInt($(this).val()) || 1;
            const total = harga * qty;

            row.find('.display-total').text("Rp. " + total.toLocaleString());
            row.find('input[name="total_harga[]"]').val(total);
            hitungTotal();
        });

        // ❌ Hapus barang dari tabel
        $(document).on('click', '.hapus-barang', function () {
            $(this).closest('tr').remove();
            if ($('#tabel-barang tbody tr').length === 0) {
                $('#tabel-barang tbody').html('<tr id="kosong"><td colspan="5" class="text-center">Belum ada barang.</td></tr>');
            }
            hitungTotal();
        });

        // 💰 Hitung kembalian saat input uang
        $('#total_uang').on('input', hitungTotal);

        // 🧮 Fungsi total seluruh transaksi
        function hitungTotal() {
            let total = 0;

            $('.qty').each(function () {
                const row = $(this).closest('tr');
                const harga = parseInt(row.data('harga')) || 0;
                const qty = parseInt($(this).val()) || 1;
                total += harga * qty;
            });

            $('#total_bayar').val(total);

            const bayar = parseInt($('#total_uang').val()) || 0;
            const kembali = bayar - total;
            $('#uang_kembali').val("Rp. " + kembali.toLocaleString());
        }
    });
</script>
</x-slot>

</x-app-layout>
