@extends('layouts.cms')

@section('content')

    <div class="row w-100 h-90 ">
        <img src="{{asset('/storage/app/images/mountain.jpg')}}" class="col-5 h-100 cover d-none d-md-block">
        </img>
        <div class="col-md-5 m-4 m-md-1 align-self-center mb-5">

            <h3 class="mb-4 ">Connexion</h3>
            <form method="POST" action="{{route ('cms.login')}}">
                {{csrf_field ()}}
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Entrer le nom">
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Mot de passe">
                </div>
                <span class="text-danger ">
                    @if($errors->any())
                        {{$errors->first()}}
                    @endif
                </span> <br>
                <button type="submit" class="btn btn-primary mt-2">Soumettre</button>


            </form>
        </div>

    </div>
    <div class="">

    </div>

@stop
