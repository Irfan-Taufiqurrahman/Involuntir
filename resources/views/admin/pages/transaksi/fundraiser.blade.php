@extends('admin.layout.content')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <text class="h4 mb-3 mb-md-0">Data Fundraiser</text>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap"> </button> -->
        </div>
    </div>



    <div class="table-responsive">
        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Fundraiser</th>
                    {{-- <th>Id Fundraiser</th> --}}
                    <th>Total Galang Dana</th>
                    <th>Waktu</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($dataFundraiser as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $data['name'] }}</td>
                        {{-- <td>{{ $data['prantara_donasi'] }}</td> --}}
                        <td>{{ $data['total_donasi'] }}</td>
                        <td>{{ $data['updated_at'] }}</td>
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
