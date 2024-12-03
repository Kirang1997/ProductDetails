<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://sp-ao.shortpixel.ai/client/to_auto,q_glossy,ret_img/https://inovantsolutions.com/wp-content/uploads/2021/01/FINALLLLLLLLLLLLLLLL.png">
    <title>Product List</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/datatables@1.13.0/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Product List</h1>

    <!-- DataTable -->
    <table id="productTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Images</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product['id'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['price'] }}</td>
                    <td>
                        @if(is_array($product['images']) || is_object($product['images']))
                          
                                @foreach($product['images'] as $image)
                                    <img src="{{ asset('storage/'.$image) }}" width="50" height="50" alt="product image">
                                @endforeach
                           
                        @else                                  
                     
                          
                                <img src="{{ asset('storage/'.$product['images']) }}" width="50" height="50" alt="product image">{{ $product['images'] }}
                           
                    
                        @endif
                    </td>
                    <td>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- jQuery, Bootstrap JS, and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables@1.13.0/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables with sorting
    $product_table = $('#productTable').DataTable({
        "ordering": true, // Enable sorting (this is usually enabled by default)
        "order": [[0, 'asc']], // Sort by the first column (index 0) in ascending order by default
        // Optionally, specify which columns should be sortable
        "columnDefs": [
            {
                "targets": [0, 1], // Enable sorting on columns with index 0 and 1 (you can adjust the index)
                "orderable": true  // Make columns 0 and 1 sortable
            },
            {
                "targets": [2], // Disable sorting on column 2 (e.g., image column)
                "orderable": false
            }
        ]
    });
});
</script>

</body>
</html>
