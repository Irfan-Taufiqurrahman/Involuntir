@extends('admin.layout.content')

@section('content')
    <div class="d-flex align-items-center flex-wrap grid-margin">
        <div class="d-flex">
            <text class="mr-3 d-inline h4">Users</text>
            <button type="button" class="btn btn-outline-info btn-icon-text">
                <i class="btn-icon-prepend d-inline" data-feather="download-cloud"></i>
                Tambahkan
            </button>
        </div>

        {{-- <div class="d-flex align-items-center flex-wrap text-nowrap text-primary">
            <a href="">All (100) | </a>
            <a href="" class="ml-2"> Fundraiser (2) | </a>
        </div> --}}
    </div>
    @if (Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('success') }}</li>
            </ul>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No.Telp</th>
                    <th>Role</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $user->username }}</td>
                        <td class="capitalize">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->no_telp }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="flex flex-row ">
                            <button
                                class="flex-none flex items-center justify-center w-6 h-6 text-white bg-blue-500 rounded-lg mr-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <form action="{{ route('delete.user', $user->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button
                                    class="flex-none flex items-center justify-center w-6 h-6 text-white bg-red-500 rounded-lg"
                                    type="submit" onclick="return confirm('Are you sure?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
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
