@extends('frontend.layout')

@section('content')
        <!-- main-area -->
        <main>
            <!-- breadcrumb-area -->
            <section class="breadcrumb-area d-flex align-items-center" style="background-image:url(public/assets/frontend/img/testimonial/test-bg.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                            <div class="breadcrumb-wrap text-center">							
                                <div class="breadcrumb-title mb-30">
                                    <h2>Shop</h2>                                   
                                </div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">News</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
			<!-- shop-area -->
            <section class="shop-area pt-120 pb-120 p-relative wow fadeInUp animated" data-animation="fadeInUp animated" data-delay=".2s">
                <div class="container">
					<div class="row">
						<div class="col-lg-6 col-sm-6">
						<h6 class="mt-20 mb-30">Showing 1–9 of 10 results</h6>
						</div>
						<div class="col-lg-6 col-sm-6 text-right">
							<select name="orderby" class="orderby" aria-label="Shop order">
								<option value="menu_order" selected="selected">Default sorting</option>
								<option value="popularity">Sort by popularity</option>
								<option value="rating">Sort by average rating</option>
								<option value="date">Sort by latest</option>
								<option value="price">Sort by price: low to high</option>
								<option value="price-desc">Sort by price: high to low</option>
							</select>
						</div>
					</div>
                    <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product mb-40">
                                            <div class="product__img">
                                                <a href="shop-details.html"><img src="public/assets/frontend/img/shop/img4.jpg" alt=""></a>
                                                <div class="product-action text-center">
                                                   
                                                    <a href="shop-details.html">Add Cart</a>
                                                    
                                                </div>
                                            </div>
                                            <div class="product__content text-center pt-30">
                                                <span class="pro-cat"><a href="#">Chair</a></span>
                                                <h4 class="pro-title"><a href="shop-details.html">Bakari Product</a></h4>
                                                <div class="price">
                                                    <span>$95.00</span>
                                                    <span class="old-price">$120.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product mb-40">
                                            <div class="product__img">
                                                <a href="shop-details.html"><img src="public/assets/frontend/img/shop/img5.jpg" alt=""></a>
                                                <div class="product-action text-center">
                                                   
                                                    <a href="shop-details.html">Add Cart</a>
                                                    
                                                </div>
                                            </div>
                                            <div class="product__content text-center pt-30">
                                                <span class="pro-cat"><a href="#">Cloths</a></span>
                                                <h4 class="pro-title"><a href="shop-details.html">Romada Product</a></h4>
                                                <div class="price">
                                                    <span>$95.00</span>
                                                    <span class="old-price">$120.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product mb-40">
                                            <div class="product__img">
                                                <a href="shop-details.html"><img src="public/assets/frontend/img/shop/img6.jpg" alt=""></a>
                                                <div class="product-action text-center">
                                                   
                                                    <a href="shop-details.html">Add Cart</a>
                                                    
                                                </div>
                                            </div>
                                            <div class="product__content text-center pt-30">
                                                <span class="pro-cat"><a href="#">Light</a></span>
                                                <h4 class="pro-title"><a href="shop-details.html">Sikkar Product</a></h4>
                                                <div class="price">
                                                    <span>$95.00</span>
                                                    <span class="old-price">$120.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product mb-40">
                                            <div class="product__img">
                                                <a href="shop-details.html"><img src="public/assets/frontend/img/shop/img7.jpg" alt=""></a>
                                                <div class="product-action text-center">
                                                   
                                                    <a href="shop-details.html">Add Cart</a>
                                                    
                                                </div>
                                            </div>
                                            <div class="product__content text-center pt-30">
                                                <span class="pro-cat"><a href="#">Headphone</a></span>
                                                <h4 class="pro-title"><a href="shop-details.html">Minners Product</a></h4>
                                                <div class="price">
                                                    <span>$95.00</span>
                                                    <span class="old-price">$120.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product mb-40">
                                            <div class="product__img">
                                                <a href="shop-details.html"><img src="public/assets/frontend/img/shop/img8.jpg" alt=""></a>
                                                <div class="product-action text-center">
                                                   
                                                    <a href="shop-details.html">Add Cart</a>
                                                    
                                                </div>
                                            </div>
                                            <div class="product__content text-center pt-30">
                                                <span class="pro-cat"><a href="#">table</a></span>
                                                <h4 class="pro-title"><a href="shop-details.html">Dolando Product</a></h4>
                                                <div class="price">
                                                    <span>$95.00</span>
                                                    <span class="old-price">$120.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product mb-40">
                                            <div class="product__img">
                                                <a href="shop-details.html"><img src="public/assets/frontend/img/shop/img9.jpg" alt=""></a>
                                                <div class="product-action text-center">
                                                   
                                                    <a href="shop-details.html">Add Cart</a>
                                                    
                                                </div>
                                            </div>
                                            <div class="product__content text-center pt-30">
                                                <span class="pro-cat"><a href="#">Cloths</a></span>
                                                <h4 class="pro-title"><a href="shop-details.html">Romada Product</a></h4>
                                                <div class="price">
                                                    <span>$95.00</span>
                                                    <span class="old-price">$120.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="col-lg-4 col-md-6">
                                        <div class="product mb-40">
                                            <div class="product__img">
                                                <a href="shop-details.html"><img src="public/assets/frontend/img/shop/img1.jpg" alt=""></a>
                                                <div class="product-action text-center">
                                                   
                                                    <a href="shop-details.html">Add Cart</a>
                                                    
                                                </div>
                                            </div>
                                            <div class="product__content text-center pt-30">
                                                <span class="pro-cat"><a href="#">Cloths</a></span>
                                                <h4 class="pro-title"><a href="shop-details.html">Medidove Product</a></h4>
                                                <div class="price">
                                                    <span>$95.00</span>
                                                    <span class="old-price">$120.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product mb-40">
                                            <div class="product__img">
                                                <a href="shop-details.html"><img src="public/assets/frontend/img/shop/img2.jpg" alt=""></a>
                                                <div class="product-action text-center">
                                                   
                                                    <a href="shop-details.html">Add Cart</a>
                                                    
                                                </div>
                                            </div>
                                            <div class="product__content text-center pt-30">
                                                <span class="pro-cat"><a href="#">Cloths</a></span>
                                                <h4 class="pro-title"><a href="shop-details.html">Legend Product</a></h4>
                                                <div class="price">
                                                    <span>$95.00</span>
                                                    <span class="old-price">$120.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product mb-40">
                                            <div class="product__img">
                                                <a href="shop-details.html"><img src="public/assets/frontend/img/shop/img3.jpg" alt=""></a>
                                                <div class="product-action text-center">
                                                   
                                                    <a href="shop-details.html">Add Cart</a>
                                                    
                                                </div>
                                            </div>
                                            <div class="product__content text-center pt-30">
                                                <span class="pro-cat"><a href="#">Table</a></span>
                                                <h4 class="pro-title"><a href="shop-details.html">Akari Product</a></h4>
                                                <div class="price">
                                                    <span>$95.00</span>
                                                    <span class="old-price">$120.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                    </div>
					<div class="row">
                    <div class="col-12">
                        <div class="pagination-wrap mt-50 text-center">
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item"><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                                        <li class="page-item active"><a href="#">1</a></li>
                                        <li class="page-item"><a href="#">2</a></li>
                                        <li class="page-item"><a href="#">3</a></li>
                                        <li class="page-item"><a href="#">...</a></li>
                                        <li class="page-item"><a href="#">10</a></li>
                                        <li class="page-item"><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                                    </ul>
                                </nav>
                            </div>
                    </div>
                <div></div></div>
                </div>
            </section>
            <!-- shop-area-end -->
        </main>
        <!-- main-area-end -->
       @endsection