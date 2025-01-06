@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Items</h1>
    <ul>
        @foreach ($items as $item)
            <li>{{ $item->name }} - {{ $item->amount }}</li>
        @endforeach
    </ul>
</div>
@endsection
