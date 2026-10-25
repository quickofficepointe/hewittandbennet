@extends('layouts.portal')
@section('pageTitle', $title)

@section('content')
<x-portal.card :title="$title">
    <x-slot:actions><x-portal.button size="sm" variant="secondary" type="button" onclick="window.print()" icon="fa-print">Print</x-portal.button></x-slot:actions>
    @include('portal.partials.timetable', ['entries' => $entries])
</x-portal.card>
@endsection
