@extends('layouts.cms')

@section('home_menu', 'active')
@section('page_title', 'Accueil')
@section('content')
    <form class="mr-3" method="post" action="{{route ('cms.mount_point_icecast')}}">
        {{csrf_field ()}}
        <label for="audio-location">Url du point de montage du serveur Icecast</label>
        <br>
        <input class="form-control " name="mount_point" type="text" id="audio-location" value="{{\App\Setting::get ('audio_url_mount_point')}}"><br>
        <label for="command-location">Url du serveur rtl_fm / Lame / Ezstream</label>
        <br>
        <input class="form-control " name="url_server" type="text" id="command-location" value="{{\App\Setting::get ('url_server')}}"><br>
        <input type="submit" class="btn btn-primary" value="Soumettre">
    </form>
@stop
