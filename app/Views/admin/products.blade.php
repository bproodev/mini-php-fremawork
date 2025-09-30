@extends('layouts.admin')

@section('title', 'Admin Products')

@section('content')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Liste des Produits </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Produits</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Liste des Produits</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Image </th>
                            <th> Nom du Produit </th>
                            <th> Prix </th>
                            <th> Catégorie </th>
                            <th> Statut </th>
                            <th> Actions </th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>
                                <img src="{{ asset('uploads/' . $product['product_image']) }}" class="me-2" alt="image">
                                </td>
                                <td> {{ $product['product_name'] }} </td>
                                <td>{{ $product['product_price'] }} FCFA</td>
                                <td>{{ $product['category'] }}</td>
                                <td>
                                <label class="badge badge-gradient-{{ $product['status'] === 'active' ? 'success' : 'danger' }}">{{ strtoupper($product['status']) }}</label>
                                </td>
                                <td>
                                <a href="{{ BASE_PATH }}/admin/products/{{ $product['id'] }}/edit" class="btn btn-gradient-primary btn-sm">Edit</a>
                                <form action="{{ BASE_PATH }}/admin/products/{{ $product['id'] }}" method="POST" style="display:inline;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-gradient-danger btn-sm">Delete</button>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
@endsection