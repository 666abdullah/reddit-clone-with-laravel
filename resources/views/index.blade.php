<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

    <!--Add product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" id="addProductForm" enctype="multipart/form-data">
        <div class="modal-body">
            @csrf
            <input type="text" name="name" class="form-control" placeholder="Enter name of Product" required>
            <input type="number" name="qty" class="form-control" placeholder="Quantity of Product" required>
            <input type="text" name="details" class="form-control" placeholder="Deatils of the Product" required>
            <input type="file" name="avatar" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="addProductBtn">Add Product</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<!--End Add product Modal -->

    <!--Edit product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" id="editProductForm" enctype="multipart/form-data">
        <div class="modal-body">
            @csrf
            <input type="hidden" name="edit_id" class="form-control" id="edit-id" placeholder="Enter name of Product" required>
            <input type="text" name="edit_name" class="form-control" id="edit-name" placeholder="Enter name of Product" required>
            <input type="number" name="edit_qty" class="form-control" id="edit-qty" placeholder="Quantity of Product" required>
            <input type="text" name="edit_details" class="form-control" id="edit-details" placeholder="Deatils of the Product" required>
            <input type="file" name="edit_avatar" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="updateProductBtn">Update Product</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<!--End Edit product Modal -->


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-start">Products</h3>
                        <button class="btn btn-primary btn-sm text-end" id="addproduct" data-toggle="modal" data-target="#addProductModal">Add Product</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="showAllProducts">
                            <thead>
                                <tr>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Details</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                            <tr>
                                <td>{{$product->name}}</td>
                                <td>{{$product->qty}}</td>
                                <td>{{$product->details}}</td>
                                <td><img style="height: 80px; width: 100px" src="{{asset('images/'.$product->avatar)}}" alt=""></td>
                                <td><button class="btn btn-sm btn-primary editProductBtn" id="{{$product->id}}">edit</button> <button class="btn btn-sm btn-danger deleteProductBtn" id="{{$product->id}}">delete</button></td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
    $(document).ready(function(){

        function fetchall(){
            $.ajax({
                url : '{{route('fetchall')}}',
                method: 'get',
                success: function(response){
                    console.log(response)
                    $("#showAllProducts").html(response);
                }
            });
        }



        $("#addProductForm").on('submit' , function(e){
            e.preventDefault();
            const data = new FormData(this);
            $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
            $.ajax({
                url: '{{route('store')}}',
                method: 'POST',
                data:data,
                cache: false,
                contentType: false,
                processData: false ,
                dataType: 'json',
                success: function(response){
                    console.log(response);

                    fetchall();
            $("#addProductForm")[0].reset();
            $("#addProductModal").modal('hide');
                }
            });
        });



        $(".editProductBtn").on('click' , function(e){
            e.preventDefault();
            var product_id = $(this).attr('id');
            console.log(product_id);
            $.ajax({
                url: '{{route('edit')}}',
                method: 'get',
                data: {product_id:product_id},
                dataType: 'json',
                success: function(response){
                    $("#editProductModal").modal('show');
                    $("#edit-id").val(response.id);
                    $("#edit-name").val(response.name);
                    $("#edit-qty").val(response.qty);
                    $("#edit-details").val(response.details);
                    console.log(response);
                }
            });
        });



        $("#editProductForm").on('submit', function(e){
            e.preventDefault();
            const data = new FormData(this);

            $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
            $.ajax({
                url: '{{route('update')}}',
                method: 'POST',
                data:data,
                cache: false,
                contentType: false,
                processData: false ,
                dataType: 'json',
                success: function(response){
                    console.log(response);

                    fetchall();
            $("#editProductModal").modal('hide');
                }
            });

        });



        $(".deleteProductBtn").on('click' , function(e){
            e.preventDefault();
            var product_id = $(this).attr('id');
            console.log(product_id);

            $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

            $.ajax({
                url : '{{route('delete')}}',
                method : 'delete',
                data : {
                    product_id : product_id,
                },
                success: function(response){
                    console.log(response);
                    fetchall();
                }
            });
        });






    });






</script>

</html>
