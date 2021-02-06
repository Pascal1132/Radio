@extends('layouts.cms')

@section('command_menu', 'active')
@section('page_title', 'Modifier de la commande')
@section('content')
    <div class="m-3">
    <form action="{{route ('cms.command')}}" method="post">
        {{csrf_field ()}}
        <label for="command">Commande principale (#F# => Fréquence, #L# => Squelch ):</label><br>
        <textarea class="form-control ff-courier" placeholder="Commande" name="command" id="command" >{{$command}}</textarea>
        <br>
        <label for="kill_command">Commande de destruction du processus (Effectuée juste avant la commande principale) :</label><br>
        <input class="form-control ff-courier" placeholder="Commande de destruction du processus" name="kill_command" id="kill_command" value="{{\App\Setting::get ('kill_command')}}">
        <br>
        <input class="btn btn-primary" type="submit" value="Soumettre">
    </form>
    </div>
@stop
