@extends('layouts.cms')

@section('home_menu', 'active')
@section('page_title', 'Accueil')
@section('content')
    <form class="mr-3" method="post" action="{{route ('cms.mount_point_icecast')}}">
        {{csrf_field ()}}
        <label for="audio-location">Url du point de montage du serveur Icecast</label>
        <br>
        <input class="form-control " name="mount_point" type="text" id="audio-location" value="{{\App\Setting::get ('audio_url_mount_point')}}"><br>
        <input type="submit" class="btn btn-primary" value="Soumettre">
    </form>
@stop
