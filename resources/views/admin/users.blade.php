@extends('layouts.admin')

@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Users ({{ $users->total() }})</h3>

            <div class="wg-filter flex-grow">
                <form action="{{ route('admin.users') }}" method="GET">
                    <div class="search-form">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, phone..." class="flex-grow">
                        <button type="submit"><i class="icon-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        @if(Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
        @endif
        @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
        @endif

        <div class="wg-box">
            <div class="wg-table table-all-user">
                <table class="table table-striped table-bordered table-responsive" id="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="name">
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="body-title-2">
                                        {{ $user->firstname }} {{ $user->lastname }}
                                    </a>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-success">You</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?: '—' }}</td>
                            <td>
                                <span class="badge {{ $user->user_type == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ ucfirst($user->user_type) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{ route('admin.user.edit', $user->id) }}">
                                        <div class="item edit"><i class="icon-edit-3"></i></div>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#users-table').DataTable({
        paging: true,
        searching: true,
        info: true,
        lengthChange: true, // hides "Show entries" dropdown if you want
        language: {
            search: "Search:",
            paginate: {
                previous: "<i class='icon-chevron-left'></i>",
                next: "<i class='icon-chevron-right'></i>"
            }
        }
    });
    $('.dt-input').addClass('float-start mb-3').css({
        'margin-right': '100px',
    });
</script>
@endpush