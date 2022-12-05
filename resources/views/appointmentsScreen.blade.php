@extends('layouts.primary')

@section('content')
        @if (session('successMsg'))
                <div class="alert alert-success" role="alert">
                    {{ session('successMsg') }}
                </div>
        @endif
        <div class="container pt-4">
            <div class="container pt-4">
                    <a href="create" class="btn btn-primary">Create appointment </a>
                <br>
                <h1>All appointments</h1>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Date</th>
                            <th scope="col">Hour</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Created_at</th>
                            <th scope="col">Updated_at</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <th scope="col">{{ $appointment->id }}</th>
                                <th scope="col">{{ $appointment->date }}</th>                        
                                <th scope="col">{{ $appointment->hour }}</th>
                                <th scope="col">{{ $appointment->full_name }}</th>
                                <th scope="col">{{ $appointment->phone_number }}</th>
                                <th scope="col">{{ $appointment->email }}</th>
                                <th scope="col">{{ $appointment->created_at }}</th>
                                <th scope="col">{{ $appointment->updated_at }}</th>
                                <th scope="col">
                                    <form action="delete/{{ $appointment->id }}" method="POST"
                                        onclick="return confirm('Are you sure you want to delete this appointment?')">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $appointments->links() }}
            </div>
        </div>
@stop
    