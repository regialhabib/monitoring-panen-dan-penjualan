<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px
        }

        th {
            background: #f2f2f2
        }

        .text-right {
            text-align: right
        }

        .text-center {
            text-align: center
        }
    </style>
</head>

<body>

    <h3 style="text-align:center">LAPORAN PENJUALAN JERUK</h3>
    <p style="text-align:center">
        Periode:
        {{ \Carbon\Carbon::parse($tanggal_awal)->format('d/m/Y') }}
        -
        {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Jeruk</th>
                <th>Jumlah (kg)</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d/m/Y') }}
                    </td>
                    <td class="text-center">{{ $item->jenis->jenis_jeruk }}</td>
                    <td class="text-center">{{ formatKg($item->jumlah_penjualan) }}</td>
                    <td class="text-center">{{ formatRupiah($item->harga) }}</td>
                    <td class="text-center">{{ formatRupiah($item->total_harga) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL</th>
                <th class="text-center">{{ formatRupiah($total) }}</th>
            </tr>
        </tfoot>
    </table>

</body>

</html>
