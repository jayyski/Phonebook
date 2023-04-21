<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Phone Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        form {
            margin: 20px 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>

<body>
    <h1>Phone Book</h1>

    @if (session('message') == 'success')
        <div class="alert alert-success">
            {{ 'Message sent successfully' }}
        </div>
        
    @elseif (session('message') == 'deleted')
        <div class="alert alert-danger">
            {{ 'Contact deleted successfully' }}
        </div>
    @elseif (session('message') == 'created')
        <div class="alert alert-success">
            {{ 'Contact created successfully' }}
        </div>
    @endif

    <form action="/create" method="post">
        @csrf

        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="phone">Phone Number:</label>

        <input type="text" id="phone" name="phone">

        @error('phone')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="email">Email:</label>
        <input type="text" id="email" name="email">

        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="submit" value="Add Contact">
    </form>
    <table>
        <thead>
            <tr>
                <th>Name</th>

                <th>Phone Number</th>

                <th>Email</th>

                <th></th>
                <th></th>

            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <form action="/delete/{{ $user->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <td><button type="submit" class="btn btn-danger">Delete</button></td>
                    </form>
                    <td><a href="/message/{{ $user->id }}"><button class="btn btn-primary">Email</button></a></td>
                </tr>
            @endforeach
            <!-- add more rows as needed -->
        </tbody>
    </table>
</body>

</html>
