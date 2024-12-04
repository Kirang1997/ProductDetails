$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

function adjustQuantity(index, action) {
    var quantityInput = document.getElementById('quantity-' + index);
    var currentQuantity = parseInt(quantityInput.value);

    if (action === 'increase') {
        quantityInput.value = currentQuantity + 1;
    } else if (action === 'decrease' && currentQuantity > 1) {
        quantityInput.value = currentQuantity - 1;
    }
}
function addToCart(productid, quantity) {
    var quantityInput = document.getElementById(quantity).value;
    var productId = productid;       
    $.ajax({
        url: '/addProductToCart', // Laravel route for adding product
        type: 'POST',
        data: {
          product_id: productid,  // Pass product ID directly
          quantity: quantityInput  // Pass quantity directly
        },
        success: function(response) {
         // Show success message with SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'produt Added to cart Successfully',          
            confirmButtonText: 'OK'
          }).then(function() {
            var setquantityInput = document.getElementById(quantity); // Use the specific ID of your input
            setquantityInput.value = 1;        
          });
        },
        error: function(error) {
         // Show error message with SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'There was an error adding the product to cart. Please try again later.',
            confirmButtonText: 'OK'
          });
          console.error('Error:', error); // Log the error for debugging
        }
      });
   
}
const modalElement = document.getElementById('productModal');
const modal = new bootstrap.Modal(modalElement);

// Add event listener for modal close
modalElement.addEventListener('hidden.bs.modal', function () {
  // Reset the form on modal close
  document.getElementById('productForm').reset();
  $('#nameError').hide();
  $('#priceError').hide();
  $('#imagesError').hide();
  $('#productName').removeClass('is-invalid');
  $('#productPrice').removeClass('is-invalid');
  $('#productImages').removeClass('is-invalid');
});

// Handle form submission with validation
$('#submitProductForm').click(function() {
    var isValid = true;

    // Validate product name
    if ($('#productName').val().trim() === '') {
      $('#productName').addClass('is-invalid');
      $('#nameError').show();
      isValid = false;
    } else {
      $('#productName').removeClass('is-invalid');
      $('#nameError').hide();
    }

    // Validate price
    var price = $('#productPrice').val();
    if (price === '' || isNaN(price) || price <= 0) {
      $('#productPrice').addClass('is-invalid');
      $('#priceError').show();
      isValid = false;
    } else {
      $('#productPrice').removeClass('is-invalid');
      $('#priceError').hide();
    }

    // Validate images
    if ($('#productImages')[0].files.length === 0) {
      $('#productImages').addClass('is-invalid');
      $('#imagesError').show();
      isValid = false;
    } else {
      $('#productImages').removeClass('is-invalid');
      $('#imagesError').hide();
    }

    // If all fields are valid, submit the form
    if (isValid) {
      var formData = new FormData($('#productForm')[0]);
      var productName = $('#productName').val(); // Get product name from the form
      $.ajax({
        url: '/addProduct', // Laravel route for adding product
        type: 'POST',
        data: formData,
        processData: false,  // Important for sending form data as multipart
        contentType: false,  // Important for sending form data as multipart
        success: function(response) {
         // Show success message with SweetAlert
        Swal.fire({
            icon: 'success',
            title: productName+'Added Successfully',          
            confirmButtonText: 'OK'
          }).then(function() {
            // Reload the page after clicking "OK"
            location.reload();
          });
          modal.hide(); // Hide modal after successful submission
          document.getElementById('productForm').reset(); // Reset the form

        },
        error: function(error) {
         // Show error message with SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'There was an error adding the product. Please try again later.',
            confirmButtonText: 'OK'
          });
          console.error('Error:', error); // Log the error for debugging
        }
      });
    }
  });

  $('#goToMyCart').click(function() {
    $('#myProduct').hide();
    $('#myCart').show();

    //Send a GET request to fetch cart data
            $.ajax({
                url: '/getAllCart', // Assuming this is the endpoint to get cart data
                type: 'GET',
                success: function(response) {                
                    // Check if the response data is not empty
                    if (response && response.Data.length > 0) {
                        let data=response.Data;
                        // Empty the current cart content
                        $('#myCart').empty();                    
                        // Add cart content dynamically
                        $.each(data, function(index, product) {
                            // Start building the product card HTML
                     
                            let productCard = `
                            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                                <div class="card dark h-1000">
                                    <div class="card-body p-0">
                                        ${product.images.length > 1 ? `
                                        <div id="carouselC-${index}" class="carousel slide rounded p-2 w-100" data-bs-ride="carousel" data-bs-interval="3000">
                                            <div class="carousel-inner rounded">
                                                ${product.images.map((image, imgIndex) => `
                                                    <div class="carousel-item ${imgIndex === 0 ? 'active' : ''} rounded">
                                                        <img src="storage/${image}" class="d-block w-100 fixed-image" alt="...">
                                                    </div>
                                                `).join('')}
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselC-${index}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselC-${index}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                        ` : `<img src="${product.images[0]}" class="card-img-top fixed-image" alt="...">`}
                                        
                                        <div class="text-section p-2">
                                            <h5 class="card-title">${product.product_name}</h5>
                                            <p class="card-text">Discover the perfect blend of innovation, quality, and functionality with our product. Designed to cater to your unique needs, it combines modern design with exceptional performance to deliver a seamless experience. Whether you're looking for reliability, style, or convenience, this product is built to exceed expectations and enhance your everyday life. Try it today and experience the difference for yourself!</p>
                                        </div>
                                        <div class="card-footer text-body-secondary d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-start">
                                                <div class="fw-bold text-white">Price : ₹ ${product.product_price} /-</div>
                                                
                                                <!-- Quantity Controls -->
                                                 <div class="fw-bold text-white ms-5 ps-5">Qyantity : ${product.quantity}</div>                                                                                                                                                                                                                                         
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                            // Append the generated product card to the myCart div
                            $('#myCart').append(productCard);
                              // Initialize the carousel after adding it to the DOM
                          var carousel = new bootstrap.Carousel(document.getElementById(`carouselC-${index}`));
                          carousel.cycle();  // Start the carousel if needed   
                        });
                          
                        
                        // Show the cart section and hide the product section
                        $('#myproduct').hide();
                        $('#myCart').show();
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Your cart is empty',
                            text: 'Your cart is empty.',
                            confirmButtonText: 'OK'
                          }).then(function() {
                            // Reload the page after clicking "OK"
                            location.reload();
                          });
                    }
                },
                error: function() {
                    // Show an error message if the request fails
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong while fetching the cart!',
                    }).then(function() {
                        // Reload the page after clicking "OK"
                        location.reload();
                      });
                }
            });
  });

  function RemoveProduct(id){
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this product?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Make an HTTP request to delete the item
            $.ajax({
                url: '/deleteProduct', // Replace with your delete route
                type: 'POST', // HTTP method
                data: {
                  product_id: id,  // Pass product ID directly               
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'The item has been deleted.',
                        'success'
                    );
                    // Optionally, refresh the page or remove the item from the DOM
                    location.reload(); // Example: Reload the page
                },
                error: function(error) {
                    Swal.fire(
                        'Error!',
                        'There was an issue deleting the item. Please try again.',
                        'error'
                    );
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelled',
                'The item was not deleted.',
                'info'
            );
        }
    });

  }
 