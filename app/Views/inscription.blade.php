@extends("layouts.app")

@section("title", "Inscription")

@section("content")
    <h1>Page d'inscription</h1>
    @if (!empty($errors))
        <ul style="color:red;">
            @foreach ($errors as $fieldErrors)
                @foreach ($fieldErrors as $error)
                    <li>{{ $error }}</li> <br>
                @endforeach
            @endforeach
        </ul>
    @endif
    @if($user)
        <p>Utilisateur, {{ $user["prenom"] }} a ete creer avec succes!</p>
    @else
        <form method="POST" action="{{ BASE_PATH. '/sinscrire' }}" enctype="multipart/form-data">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
            <br>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="fileInput">Choisissez un fichier</label>
            <input type="file" name="avatar" id="fileInput">
            <br>
            <progress id="progressBar" value="0" max="100"></progress>
            <p id="status"></p>
            <br>
            <button type="submit">S'inscrire</button>
        </form>
    @endif

@endsection

@section("scripts")
    <script src="{{ asset('assets/js/upload.js')}}"></script>
@endsection