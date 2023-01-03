@extends('admin.layout.content')
@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <text class="mb-3 mb-md-0 h4">Data Transaksi</text>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">Filter</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Terbaru</a>
                <a class="dropdown-item" href="#">Terlama</a>
                <a class="dropdown-item" href="#">Paling Tinggi</a>
                <a class="dropdown-item" href="#">Paling Rendah</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Galang Dana</th>
                    <th>Nominal</th>
                    <th>Waktu</th>
                    <th>Via</th>
                    <th>Fundraiser</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataDonatur as $data )
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>

                        <td class="capitalize">{{ $data['campaign']['judul_campaign'] }}</td>

                        <td>{{ $data['donasi'] }}</td>

                        <td>{{ $data['created_at'] }}</td>

                        @if (!$data['prantara_donasi'])
                            <td class="uppercase">{{ $data['metode_pembayaran'] }}</td>
                        @else
                            <td class="uppercase">{{ $data['prantara_donasi'] }}</td>
                        @endif

                        <td class="capitalize">{{ $data['nama'] }}</td>

                        @if ($data['status_donasi'] == 'Approved')
                            <td
                                class="text-xs font-medium inline-block my-1 py-1 px-2 Capitalize rounded badge badge-success  last:mr-0 mr-1">
                                Diterima</td>
                        @elseif ($data['status_donasi'] == 'Pending' || $data['status_donasi'] == 'Pendding')
                            <td
                                class="text-xs font-medium inline-block my-1 py-1 px-2 Capitalize rounded badge badge-warning  last:mr-0 mr-1">
                                Pending</td>
                        @elseif ($data['status_donasi'] == 'Rejected' || $data['status_donasi'] == 'Refund' ||
                            $data['status_donasi'] == 'Denied')
                            <td
                                class="text-xs font-medium inline-block my-1 py-1 px-2 Capitalize rounded badge badge-danger last:mr-0 mr-1">
                                Ditolak</td>
                        @else
                            <td
                                class="text-xs font-medium inline-block my-1 py-1 px-2 Capitalize rounded badge badge-secondary  last:mr-0 mr-1">
                                {{ $data['status_donasi'] }}</td>
                        @endif

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-5">
                            Data Tidak Tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
