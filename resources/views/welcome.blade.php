@extends('layout.sneat')

@section('menu')
<div class="portlet-title">
    <div style="display: inline-block; margin-left: 15px;  margin-top: 15px; font-size: 25px; font-weight: bold;">
        Welcome,  {{auth()->user()->name}}
    </div>
    <div style="margin-left: 15px; font-size: 18px; margin-bottom: 15px;">
        {{ strtoupper(auth()->user()->role) }}
    </div>
</div>
@endsection
