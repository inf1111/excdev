<div class="alert alert-success" role="alert">
    Баланс: {{ Auth::user()->balance }}
</div>

<h4>Последние операции</h4>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">amount</th>
            <th scope="col">date</th>
            <th scope="col">description</th>
        </tr>
        </thead>
        <tbody>
        @foreach($recentOps as $op)
            <tr>
                <td>{{ $op->id }}</td>
                <td>{{ $op->amount }}</td>
                <td>{{ $op->date }}</td>
                <td>{{ $op->description }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
