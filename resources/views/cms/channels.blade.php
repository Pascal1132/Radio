@extends('layouts.cms')

@section('channel_menu', 'active')
@section('page_title', 'Chaînes enregistrées')
@section('content')
    <div class="m-3">
        <table class="text-center " style="margin: auto; max-width: 600px; min-width: 300px; ">
            <thead>
                <th>Fréquence</th>
                <th>Nom de la chaîne</th>
            </thead>
            <tbody>
                @forelse($channels ?? [] as $channel)
                    <td>{{$channel['frequency']}}</td>
                    <td>{{$channel['name']}}</td>

                @empty
                        <td colspan="2">Vous n'avez entré aucun nom de chaîne</td>
                @endforelse
            </tbody>
            <tfooter>
                <td colspan="2"><em><a href="" class="text-secondary">Ajouter une chaine</a></em></td>
            </tfooter>
        </table>


    </div>
@stop
