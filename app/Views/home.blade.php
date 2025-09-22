@extends('layouts.app')

@section('title', 'Home')

@section("content")
    <h1 class="title">Salut a toi le pro!</h1>

    <ul class="user-list">
        @foreach($users as $user)
            <li>
                <p><strong>Nom Complet : </strong>{{ $user['prenom'] }} {{ $user['nom'] }}</p>
            </li>
        @endforeach
    </ul>

    <a href="<?= BASE_PATH ?>/inscription">Inscrivez vous</a>
    <script src="<?= BASE_PATH ?>/assets/js/script.js"></script>
@endsection

