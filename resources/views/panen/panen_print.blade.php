<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Panen</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h3 {
            margin: 0;
        }

        .header p {
            margin: 5px 0;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
            text-align: center;
        }

        td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <h3>LAPORAN PANEN JERUK</h3>
        <p>
            Periode:
            {{ \Carbon\Carbon::parse($tanggal_awal)->format('d/m/Y') }}
            -
            {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Jenis Jeruk</th>
                <th width="15%">Jumlah (kg)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_panen)->format('d/m/Y') }}
                    </td>
                    <td class="text-center">{{ $item->jenis->jenis_jeruk }}</td>
                    <td class="text-center">
                        {{ formatKg($item->jumlah_panen) }} 
                    </td>
                    <td class="text-center">{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
