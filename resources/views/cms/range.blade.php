@extends('layouts.cms')

@section('range_menu', 'active')
@section('page_title', 'Écart des fréquences disponibles')
@section('content')
    <div class="m-3">
        <form action="{{route ('cms.range')}}" method="post">
            {{csrf_field ()}}
            <label for="min">Minimum (MHz): </label>
            <input class="form-control" type="numeric" id='min' name="freq_min" placeholder="Defaul: 80" value="{{\App\Setting::get ('freq_min')}}"><br>
            <label for="max">Maximum (MHz): </label>
            <input class="form-control" type="numeric" id='max' name="freq_max" placeholder="Defaul: 120" value="{{\App\Setting::get ('freq_max')}}">
            <br>
            <input class="btn btn-primary" type="submit" value="envoyer">
        </form>
    </div>
@stop
