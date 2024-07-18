@extends('layouts.app')

@section('content')
<div id="app">
    <chat-app></chat-app>
</div>
@endsection

@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush
