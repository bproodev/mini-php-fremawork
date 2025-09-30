@extends('layouts.app')

@section('title', 'Liste des Produits')

@section("content")
		<!-- Start Hero Section -->
			<div class="hero">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-8">
							<div class="intro-excerpt">
								<h1>Explorer</h1>
								<p class="mb-4">Faites votre choix parmi notre sélection de produits de qualité.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->

		

		<div class="untree_co-section product-section before-footer-section">
		    <div class="container">
		      	<div class="row">
					@foreach($produits as $produit)
		      		<!-- Start Column 1 -->
					<div class="col-12 col-md-4 col-lg-3 mb-5">
						<a class="product-item" href="{{BASE_PATH}}/produits/{{ $produit['slug'] }}">
							<img src="{{ asset('uploads/'.$produit['product_image']) }}" class="img-fluid product-thumbnail">
							<h3 class="product-title">{{ $produit['product_name'] }}</h3>
							<strong class="product-price">{{ $produit['product_price'] }} FCFA</strong>

							<span class="icon-cross">
								<img src="{{ asset('assets/images/cross.svg') }}" class="img-fluid">
							</span>
						</a>
					</div> 
					<!-- End Column 1 -->
					@endforeach
		      	</div>
		    </div>
		</div>
@endsection