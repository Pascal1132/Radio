@extends('layouts.cms')

@section('command_menu', 'active')
@section('page_title', 'Modifier de la commande')
@section('content')
    <div class="m-3">
    <form action="{{route ('cms.command')}}" method="post">
        {{csrf_field ()}}
        <label for="commande">Commande (la variable #F# correspond à la fréquence ):</label><br>
        <textarea class="form-control ff-courier" placeholder="Commande" name="command" id="commande" >{{$command}}</textarea>
        <br>
        <input class="btn btn-primary" type="submit" value="Soumettre">
    </form>
    </div>
@stop
