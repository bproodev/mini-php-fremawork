@extends('layouts.admin')
@section('title', 'Editer un Produit')

@section('content')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Form elements </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Forms</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Form elements</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Editer Un produit</h4>
                    <p class="card-description"> Formulaire de modification de produit </p>
                    <form class="forms-sample" action="{{ BASE_PATH }}/admin/products/{{ $product['id'] }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="exampleInputName1" >Nom du Produit</label>
                        <input type="text" name="product_name" class="form-control" id="exampleInputName1" placeholder="Nom du Produit" value="{{ $product['product_name'] }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3" >Prix du Produit</label>
                        <input type="number" name="product_price" class="form-control" id="exampleInputEmail3" placeholder="Prix du Produit" value="{{ $product['product_price'] }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword4" >Courte description</label>
                        <input type="text" name="product_description" class="form-control" id="exampleInputPassword4" placeholder="Courte description" value="{{ $product['product_description'] }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleSelectGender">Statut</label>
                        <select class="form-select" id="exampleSelectGender" name="status">
                          <option value="active" {{ $product['status'] === 'active' ? 'selected' : '' }}>Actif</option>
                          <option value="inactive" {{ $product['status'] === 'inactive' ? 'selected' : '' }}>Inactif</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleSelectGender">Catégorie</label>
                        <select class="form-select" id="exampleSelectGender" name="category">
                          <option value="Vedettes" {{ $product['category'] === 'Vedettes' ? 'selected' : '' }}>Vedettes</option>
                          <option value="Nouveau" {{ $product['category'] === 'Nouveau' ? 'selected' : '' }}>Nouveauté</option>
                          <option value="Promotionel" {{ $product['category'] === 'Promotionel' ? 'selected' : '' }}>Promotionel</option>
                          <option value="Luxe" {{ $product['category'] === 'Luxe' ? 'selected' : '' }}>Produit de Luxe</option>
                          <option value="Classique" {{ $product['category'] === 'Classique' ? 'selected' : '' }}>Classique</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Image du Produit</label>
                        <input type="file" name="product_image"  class="file-upload-default">
                        <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info" disabled placeholder="Télécharger l'image">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Télécharger</button>
                          </span>
                        </div>
                        <img src="{{ asset('uploads/' . $product['product_image']) }}" width="100" alt="">
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Description</label>
                        <textarea class="form-control" id="exampleTextarea1" name="product_specification" rows="4">{{ $product['product_specification'] }}</textarea>
                      </div>
                      <button type="submit" class="btn btn-gradient-primary me-2">Soumettre</button>
                      <button class="btn btn-light">Annuler</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/file-upload.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endsection