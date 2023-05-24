@extends('layouts.app')
@section('content')
<div>
    @foreach ($invoices as $invoice)
        <p>Invoices total_amount : {{$invoice->total_amount}}</p>
        <p>Invoices amount_before_tax : {{$invoice->amount_before_tax}}</p>
        <p>Invoices tax : {{$invoice->tax}}</p>
        <br>
    @endforeach
</div>
{{ $invoices->appends(['order' => request('order')])->links() }}
@stop