@extends('layouts.app')

@section('title', 'Details Produit')

@section("content")
		<!-- Start Hero Section -->
			<div class="hero">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>Excellent Choix</h1>
								<p class="mb-4">Un produit de qualité supérieure pour votre intérieur.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->

    <div class="untree_co-section product-section">
        <div class="container">
            <div class="row">

                <div class="col-md-6 mb-5">
                    <img src="{{ asset('uploads/'.$produit['product_image']) }}" alt="Nordic Chair" class="img-fluid product-image">
                </div>

                <div class="col-md-6">
                    <h1 class="product-title">{{ $produit['product_name'] }}</h1>
                    <h2 class="product-price">{{ $produit['product_price'] }} FCFA</h2>
                    <p class="product-description">{{ $produit['product_description'] }}</p>

                    <div class="product-options mb-4">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1"
                            class="form-control d-inline-block w-auto">
                    </div>

                    <div class="product-actions">
                        <a href="#" class="btn btn-black btn-lg">Add to Cart</a>
                    </div>

                    <hr class="my-4">

                    <div class="product-details">
                        <h5>Specifications</h5>
                        <div>{{ $produit['product_specification'] }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection