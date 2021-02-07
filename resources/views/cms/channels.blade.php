@extends('layouts.cms')

@section('channel_menu', 'active')
@section('page_title', 'Chaînes enregistrées')
@section('content')
    <div class="m-3">
        <table class="text-center table" style="margin: auto; max-width: 700px; min-width: 300px; overflow: auto">
            <thead class="bg--1 text-light">
            <th>Fréquence (MHz)</th>
            <th>Nom de la chaîne</th>
            <th>Options</th>
            </thead>
            <tbody id="channels-list">

            </tbody>
            <tfooter>
                <tr id="no-channel" style="display: none">
                    <td colspan="2">Vous n'avez entré aucun nom de chaîne</td>
                </tr>
                <tr>
                    <td><input type="number" class="form-control-sm form-control frequency-input" step="0.01"></td>
                    <td><input type="text" class="form-control-sm form-control name-input"></td>
                    <td>
                        <button class="btn btn-sm m-auto" id="btn-add-channel"><i class="fas fa-plus-square"></i>
                        </button>
                    </td>
                </tr>
            </tfooter>
        </table>
    </div>
    <script>
        var CSRF_TOKEN = '{{csrf_token ()}}';
        var GET_TABLE_URL = '{{route ('cms.channels.table')}}';
        var POST_CHANNEL_URL = '{{route ('cms.channel.add')}}';
        var DELETE_CHANNEL_URL = '{{route ('cms.channel.remove')}}';
    </script>
    <script type="text/javascript" src="{{ asset('public/js/cms/channels.js') }}"></script>
@stop
