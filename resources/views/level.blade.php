<!DOCTYPE html>
<html>
    <head>
        <tittle>Data Level Pengguna</tittle>
    </head>
    <body>
        <h1>Data level Pengguna</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>id</th>
                <th>Kode Level</th>
                <th>Nama Level</th>
            </tr>
            @foreach ($data as $d)
                <tr>
                    <td>{{ $d->level_id }}</td>
                    <td>{{ $d->level_kode }}</td>
                    <td>{{ $d->level_nama }}</td>
                </tr>
            @endforeach
        </table>
    </body>
    </html>