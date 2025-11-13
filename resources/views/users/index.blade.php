@extends('layouts.main')

@section('header', 'User / Karyawan')

@section('content')
<div>
  <table class="content-table">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Bergabung Sejak</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->created_at->format('d M Y') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection