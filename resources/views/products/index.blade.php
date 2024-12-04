<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="https://sp-ao.shortpixel.ai/client/to_auto,q_glossy,ret_img/https://inovantsolutions.com/wp-content/uploads/2021/01/FINALLLLLLLLLLLLLLLL.png">
    <title>Product List</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style type="text/css">
                body {
        background-color: mintcream;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        }
        .card {
        max-width: 30em;
        flex-direction: row;
        background-color: #696969;
        border: 0;
        box-shadow: 0 7px 7px rgba(0, 0, 0, 0.18);
        margin: 1em auto;
        }
        .card.dark {
        color: #fff;
        }
        .card.card.bg-light-subtle .card-title {
        color: dimgrey;
        }



        .cta-section {
        max-width: 40%;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: space-between;
        }
        .cta-section .btn {
        padding: 0.3em 0.5em;
        /* color: #696969; */
        }
        .card.bg-light-subtle .cta-section .btn {
        background-color: #898989;
        border-color: #898989;
        }
        @media screen and (max-width: 475px) {
        .card {
            font-size: 0.9em;
        }
        }
        .fixed-image {
                width: 100%;
                height: 200px; /* Set desired height */
                object-fit: cover; /* Ensures the image covers the area without distortion */
            }
            .w-10{
                width: 10% !important;
            }
</style>
</head>
<body>
    <nav class="navbar bg-dark fixed-top w-100">
        <div class="container-fluid">
            <!-- Logo and Brand -->
            <a class="navbar-brand" href="#">
                <img src="https://sp-ao.shortpixel.ai/client/to_auto,q_glossy,ret_img/https://inovantsolutions.com/wp-content/uploads/2021/01/FINALLLLLLLLLLLLLLLL.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top w-100">            
            </a>
            <div class="d-flex align-items-center">
                <span class='text-warning'><h5>Inovant Solutions | Task - PHP Developer</h5></span>
            </div>
            
            <!-- Navbar Links and Buttons -->
            <div class="d-flex align-items-center">
                <!-- Home Link -->
                <a href="{{ route('home') }}" class="btn btn-link text-white me-2">Home</a>
    
                <!-- Add Product Button -->
                <button type="button" class="btn btn-primary p-1 me-1" data-bs-toggle="modal" data-bs-target="#productModal">
                    Add Product
                </button>
                    
                <!-- My Cart Button -->
                <button type="button" class="btn btn-warning p-1" id="goToMyCart">
                    My Cart <i class="bi bi-cart"></i>
                </button>
            </div>
        </div>
    </nav>
    
<div class="container mt-5">
   <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">Add Product Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="productForm" enctype="multipart/form-data">
                <div class="mb-3 row">
                <label for="productName" class="col-sm-4 col-form-label"> <span class='text-danger'>*</span> Product Name </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="productName" name="name" required>
                    <div id="nameError" class="invalid-feedback">Please enter a product name.</div>
                    
                </div>
                </div>
                <div class="mb-3 row">
                <label for="productPrice" class="col-sm-4 col-form-label"> <span class='text-danger'>*</span> Price </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="productPrice" name="price" required step="0.01">
                    <div id="priceError" class="invalid-feedback">Please enter a valid price.</div>
                </div>
                </div>
                <div class="mb-3 row">
                <label for="productImages" class="col-sm-4 col-form-label"> <span class='text-danger'>*</span> Images</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" id="productImages" name="images[]" multiple>
                    <div id="imagesError" class="invalid-feedback">Please upload at least one image.</div>
                </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="submitProductForm">Submit</button>
            </div>
        </div>
        </div>
    </div>
    <div class="row" id="myProduct">
       
        @foreach($products as $product)
        <div class="col-12 col-sm-6 col-lg-4 mb-0">
            <div class="card dark h-1000">
                <div class="card-body p-0">
                    <div class="card-header d-flex justify-content-end">
                        <button type="button" class="btn btn-danger rounded-circle me-1" onclick="RemoveProduct({{$product['id']}})"><i class="bi bi-trash-fill"></i></button>                        
                    </div>
                @if(is_array($product['images']) || is_object($product['images']))                          
                    <!-- Carousel for product images -->
                    <div id="carousel-{{ $loop->index }}" class="carousel slide rounded p-2 w-100" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner rounded">
                            @foreach($product['images'] as $image)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }} rounded">
                                <img src="{{ asset('storage/'.$image) }}" class="d-block w-100 fixed-image" alt="...">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $loop->index }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $loop->index }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>                    
                @else
                    <img src="{{ asset('storage/'.$image) }}" class="card-img-top fixed-image" alt="...">                                               
                @endif 
               
                    <div class="text-section p-2">
                        <h5 class="card-title text-center">{{ $product['name'] }}</h5>
                        <p class="card-text p-3">Discover the perfect blend of innovation, quality, and functionality with our product. Designed to cater to your unique needs, it combines modern design with exceptional performance to deliver a seamless experience. Whether you're looking for reliability, style, or convenience, this product is built to exceed expectations and enhance your everyday life. Try it today and experience the difference for yourself!</p>
                    </div>
                    <div class="card-footer text-body-secondary d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-start">
                            <div class="fw-bold text-white pt-2">Price : ₹ {{ $product['price'] }} /-</div>
                            <!-- Quantity Controls -->                           
                                <!-- Minus Button -->
                                
                                <button class="btn border border-white text-light ms-4" id="decrease-{{ $loop->index }}" onclick="adjustQuantity({{ $loop->index }}, 'decrease')">
                                    <i class="bi bi-dash"></i>
                                </button>
                                
                                <!-- Quantity Display -->
                                <input type="text" id="quantity-{{ $loop->index }}" value="1" class="form-control text-center w-10 mx-0 p-0" readonly>
                                
                                <!-- Plus Button -->
                                <button class="btn border border-white text-light me-3" id="increase-{{ $loop->index }}" onclick="adjustQuantity({{ $loop->index }}, 'increase')">
                                    <i class="bi bi-plus"></i>
                                </button>
                          

                            <button onClick="addToCart('{{ $product['id'] }}','quantity-{{ $loop->index }}')" class="btn btn-warning rounded-pill ">Add <i class="bi bi-cart"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row" id="myCart">
    </div>
</div>

<script src="{!! asset('js/index.js?version=1.1112') !!}"></script>

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css" rel="stylesheet">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.js"></script>
</body>
</html>
