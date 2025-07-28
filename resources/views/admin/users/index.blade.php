@extends('layouts.app')

@section('title', 'Zarządzanie użytkownikami')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users"></i> Zarządzanie użytkownikami</h2>
    <div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj użytkownika
        </a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót do panelu
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nazwa</th>
                            <th>Email</th>
                            <th>Rola</th>
                            <th>Data rejestracji</th>
                            <th>Ostatnia aktualizacja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle fa-2x text-muted me-2"></i>
                                    <div>
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-decoration-none">
                                            <strong>{{ $user->name }}</strong>
                                        </a>
                                        @if($user->id === auth()->id())
                                            <small class="badge bg-info">To Ty</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                    {{ $user->role === 'admin' ? 'Administrator' : 'Użytkownik' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                            <td>{{ $user->updated_at->format('d.m.Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Brak użytkowników</h5>
                <p class="text-muted">Dodaj pierwszego użytkownika do systemu</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Dodaj użytkownika
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Potwierdź usunięcie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Czy na pewno chcesz usunąć użytkownika <strong id="userName"></strong>?
                <br><small class="text-muted">Tej operacji nie można cofnąć.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Usuń użytkownika</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(userId, userName) {
    document.getElementById('userName').textContent = userName;
    document.getElementById('deleteForm').action = '/admin/users/' + userId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection