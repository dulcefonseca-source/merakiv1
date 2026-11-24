
@extends('layouts.app')

@section('title', 'Clientas')
@section('page-title', 'Gestión de clientas')

@section('content')

<div class="clients-heading">
    <div>
        <span class="heading-label">MERAKI ESTUDIO DE BELLEZA</span>
        <h2>Directorio de clientas</h2>
        <p>Un espacio para gestionar y conocer mejor a quienes confían en Meraki.</p>
    </div>

    <a href="{{ route('clients.create') }}" class="btn btn-meraki">
        <i class="bi bi-person-plus me-2"></i>
        Nueva clienta
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ session('error') }}
    </div>
@endif

<div class="content-card clients-card">

    <div class="clients-toolbar">
        <div class="directory-info">
            <h5>Directorio de clientas</h5>
            <p>
                <span class="directory-count">{{ $clients->total() }}</span>
                {{ $clients->total() === 1 ? 'clienta registrada' : 'clientas registradas' }}
            </p>
        </div>

        <form action="{{ route('clients.index') }}" method="GET" class="search-form">

            <div class="search-box">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Buscar por nombre o teléfono..."
                >
            </div>

            <button type="submit" class="btn btn-meraki-outline">
                Buscar
            </button>

            @if($search)
                <a href="{{ route('clients.index') }}" class="btn btn-clear">
                    <i class="bi bi-x-lg me-1"></i>
                    Limpiar
                </a>
            @endif

        </form>
    </div>

    <div class="table-responsive">
        <table class="table clients-table align-middle">

            <thead>
                <tr>
                    <th>CLIENTA</th>
                    <th>TELÉFONO</th>
                    <th>CITAS REGISTRADAS</th>
                    <th class="text-end">ACCIONES</th>
                </tr>
            </thead>

            <tbody>

                @forelse($clients as $client)

                    <tr>
                        <td>
                            <div class="client-name">

                                <div class="client-avatar">
                                    {{ strtoupper(substr($client->name, 0, 1)) }}
                                </div>

                                <div class="client-information">
                                    <a
                                        href="{{ route('clients.show', $client) }}"
                                        class="client-profile-link"
                                    >
                                        {{ $client->name }}
                                    </a>

                                    <span>Ver ficha de clienta</span>
                                </div>

                            </div>
                        </td>

                        <td>
                            <div class="client-phone">
                                <i class="bi bi-telephone"></i>
                                <span>{{ $client->phone ?: 'No registrado' }}</span>
                            </div>
                        </td>

                        <td>
                            <span class="appointments-count">
                                {{ $client->appointments_count }}
                                {{ $client->appointments_count === 1 ? 'cita' : 'citas' }}
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons justify-content-end">

                                <a
                                    href="{{ route('clients.show', $client) }}"
                                    class="action-btn view-btn"
                                    title="Ver ficha"
                                >
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a
                                    href="{{ route('clients.edit', $client) }}"
                                    class="action-btn"
                                    title="Editar clienta"
                                >
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form
                                    action="{{ route('clients.destroy', $client) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Estás segura de eliminar esta clienta?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-btn delete-btn"
                                        title="Eliminar clienta"
                                    >
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">

                            <div class="empty-clients">
                                <div class="empty-icon">
                                    <i class="bi bi-people"></i>
                                </div>

                                <h6>
                                    {{ $search ? 'No encontramos resultados' : 'Tu directorio está esperando a su primera clienta' }}
                                </h6>

                                <p>
                                    {{ $search
                                        ? 'Intenta buscar con otro nombre o número de teléfono.'
                                        : 'Registra una clienta para comenzar a organizar sus citas y servicios.' }}
                                </p>

                                @if(!$search)
                                    <a href="{{ route('clients.create') }}" class="btn btn-meraki mt-2">
                                        <i class="bi bi-plus-lg me-2"></i>
                                        Registrar primera clienta
                                    </a>
                                @endif
                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    @if($clients->hasPages())
        <div class="pagination-container">
            {{ $clients->links() }}
        </div>
    @endif

</div>

@endsection

@push('styles')
<style>

    /* ENCABEZADO */

    .clients-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
    }

    .heading-label {
        font-size: 10px;
        letter-spacing: 1.8px;
        color: var(--meraki-primary);
        font-weight: 700;
    }

    .clients-heading h2 {
        font-family: 'Playfair Display', serif;
        margin: 7px 0;
        font-size: 29px;
        color: var(--meraki-text);
    }

    .clients-heading p {
        font-size: 13px;
        color: var(--meraki-muted);
        margin: 0;
    }

    /* DIRECTORIO */

    .clients-card {
        padding: 25px;
    }

    .clients-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .directory-info h5 {
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        margin-bottom: 6px;
        color: var(--meraki-text);
    }

    .directory-info p {
        font-size: 11px;
        color: var(--meraki-muted);
        margin: 0;
    }

    .directory-count {
        color: var(--meraki-primary-dark);
        font-weight: 700;
    }

    /* BUSCADOR */

    .search-form {
        display: flex;
        gap: 9px;
        align-items: center;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid var(--meraki-border);
        border-radius: 9px;
        padding: 0 13px;
        background: #fff;
        min-width: 270px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .search-box:focus-within {
        border-color: var(--meraki-primary);
        box-shadow: 0 0 0 3px rgba(189, 137, 128, .10);
    }

    .search-box i {
        color: var(--meraki-muted);
        font-size: 14px;
    }

    .search-box input {
        border: none;
        outline: none;
        background: transparent;
        padding: 11px 0;
        width: 100%;
        font-size: 12px;
        color: var(--meraki-text);
    }

    .search-box input::placeholder {
        color: #B6A9AA;
    }

    .btn-clear {
        border: 1px solid var(--meraki-border);
        background: white;
        color: var(--meraki-muted);
        font-size: 12px;
    }

    .btn-clear:hover {
        background: var(--meraki-ivory);
        color: var(--meraki-text);
    }

    /* TABLA */

    .clients-table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .clients-table thead th {
        background: #FAF7F5;
        color: #9D8888;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 15px 17px;
        border-top: 1px solid var(--meraki-border);
        border-bottom: 1px solid var(--meraki-border);
        white-space: nowrap;
    }

    .clients-table thead th:first-child {
        border-radius: 8px 0 0 0;
    }

    .clients-table thead th:last-child {
        border-radius: 0 8px 0 0;
    }

    .clients-table tbody td {
        padding: 16px 17px;
        border-bottom: 1px solid #F2EBE9;
        font-size: 12px;
        color: var(--meraki-text);
    }

    .clients-table tbody tr {
        transition: background .2s ease;
    }

    .clients-table tbody tr:hover {
        background: #FDFBFA;
    }

    /* IDENTIDAD DE CLIENTA */

    .client-name {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 220px;
    }

    .client-avatar {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        background: var(--meraki-rose);
        color: var(--meraki-primary-dark);
        border: 1px solid #F0DDDA;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 18px;
    }

    .client-information {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .client-information .client-profile-link,
    .client-information .client-profile-link:visited,
    .client-information .client-profile-link:active {
        color: var(--meraki-text) !important;
        text-decoration: none !important;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.3;
        transition: color .2s ease;
    }

    .client-information .client-profile-link:hover {
        color: var(--meraki-primary-dark) !important;
        text-decoration: none !important;
    }

    .client-information span {
        color: var(--meraki-muted);
        font-size: 10px;
    }

    /* TELÉFONO */

    .client-phone {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--meraki-text);
        white-space: nowrap;
    }

    .client-phone i {
        color: var(--meraki-primary);
        font-size: 13px;
    }

    /* CITAS */

    .appointments-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #F8EDF0;
        color: #A86F80;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* ACCIONES */

    .action-buttons {
        display: flex;
        gap: 7px;
    }

    .action-btn {
        border: 1px solid var(--meraki-border);
        background: white;
        color: var(--meraki-primary-dark);
        border-radius: 8px;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        transition: all .2s ease;
    }

    .action-btn:hover {
        background: var(--meraki-rose);
        border-color: #E8D2CF;
        color: var(--meraki-primary-dark);
    }

    .view-btn {
        color: #82988A;
    }

    .view-btn:hover {
        background: #EDF3EE;
        border-color: #DCE8DF;
        color: #66806E;
    }

    .delete-btn {
        color: #B66C6C;
    }

    .delete-btn:hover {
        background: #F9ECEC;
        border-color: #EED5D5;
        color: #A85858;
    }

    /* ESTADO VACÍO */

    .empty-clients {
        text-align: center;
        padding: 55px 15px;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        background: var(--meraki-rose);
        color: var(--meraki-primary);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        margin: 0 auto 16px;
    }

    .empty-clients h6 {
        font-family: 'Playfair Display', serif;
        font-size: 17px;
        color: var(--meraki-text);
    }

    .empty-clients p {
        font-size: 12px;
        color: var(--meraki-muted);
    }

    /* PAGINACIÓN */

    .pagination-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        color: var(--meraki-primary-dark);
        border-color: var(--meraki-border);
    }

    .page-link:hover {
        color: var(--meraki-primary-dark);
        background: var(--meraki-rose);
        border-color: var(--meraki-border);
    }

    .active > .page-link {
        background: var(--meraki-primary);
        border-color: var(--meraki-primary);
        color: white;
    }

    /* RESPONSIVE */

    @media (max-width: 768px) {

        .clients-heading,
        .clients-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .clients-heading .btn {
            width: 100%;
        }

        .clients-card {
            padding: 17px;
        }

        .search-form {
            width: 100%;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 180px;
        }

        .search-form button {
            flex: 1;
        }

        .clients-table {
            min-width: 600px;
        }
    }

</style>
@endpush
