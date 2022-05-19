@extends('layouts.admin')

@section('content')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="/css/datatables-pagination.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.js"></script>

    <br>

    <h4>История операций</h4>

    <br>

    <div>

        <table id="ops-table" class="table table-bordered table-hover display">
            <tbody>
                <thead class="thead-dark">
                    <th>id</th>
                    <th>amount</th>
                    <th>description</th>
                    <th>date</th>
                </thead>
            </tbody>
        </table>

    </div>

@endsection
