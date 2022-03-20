@extends('layouts.layout')

@section('content')

    {{-- App functionality list --}}

    <div class="col pb-5 text-center text-secondary" >
        <h1>Functionality List</h1>

        {{-- List errors here --}}
        @if(count($errors) > 0)

            <div class="alert alert-danger">
                <ul>
                    @foreach($errors as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Display success message here --}}
        @if(\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif


    </div>

    
    <div class="row ms-5 me-5 justify-content-center">
        <!-- Get inventory file -->
        <div class="col d-flex row-eq-height  justify-content-center">
            <div class="bg-light rounded border border-5 m-2 p-3 text-center" style="width: 100%;">
                <p class="ms-1 me-1 fs-2"><button data-bs-toggle="modal" data-bs-target="#inventFile-modal"
                style="border: none; background: none!important; padding: 0!important; color: #0D6EFD;">
                Get Inventory File
                </button></p>

                <p class="text-secondary">Download inventory file from supplier's FTP server</p>
            </div>
        </div>
        <!-- Show all items in store -->
        <div class="col d-flex row-eq-height justify-content-center">
            <div class="bg-light rounded border border-5 m-2 p-3 text-center" style="width: 100%;">
                <p class="ms-1 me-1 fs-2"><a href="index" class="text-decoration-none">Show All Items</a></p>
                <p class="text-secondary">Get a of all items in Shopify store</p>
            </div>
        </div>
        <!-- Display signle item info -->
        <div class="col d-flex row-eq-height justify-content-center">
            <div class="bg-light rounded border border-5 m-2 p-3 text-center" style="width: 100%;">
                <p class="ms-1 me-1 fs-2">
                    <button data-bs-toggle="modal" data-bs-target="#show-modal"
                    style="border: none; background: none!important; padding: 0!important; color: #0D6EFD;">
                    Get Item by ID
                    </button>
                </p>
                <p class="text-secondary">Display information about a product on your store based on a product identifier</p>
            </div>
        </div>
    </div>

    <div class="row ms-5 me-5">
        <!-- Add product to store -->
        <div class="col-4 d-flex row-eq-height justify-content-center">
            <div class="bg-light rounded border border-5 m-2 p-3 text-center" style="width: 100%;">
            <p class="ms-1 me-1 fs-2">
                <button data-bs-toggle="modal" data-bs-target="#create-modal" style="border: none; 
                background: none!important; padding: 0!important; color: #0D6EFD;">
                Add Product
                </button>
                <p class="text-secondary">Add a product from supplier's inventory list to Shopify store</p>
            </div>
        </div>
        <!-- Upadte existing store product -->
        <div class="col-4 d-flex row-eq-height justify-content-center">
            <div class="bg-light rounded border border-5 m-2 p-3 text-center" style="width: 100%;">
            <p class="ms-1 me-1 fs-2">
                <button data-bs-toggle="modal" data-bs-target="#update-modal" style="border: none; 
                background: none!important; padding: 0!important; color: #0D6EFD;">
                Update Product
                </button>
                <p class="text-secondary">Update or modify a product on your Shopify store</p>
            </div>
        </div>
        <!-- Store product in database-->
        <div class="col-4 d-flex row-eq-height justify-content-center">
            <div class="bg-light rounded border border-5 m-2 p-3 text-center" style="width: 100%;">
            <p class="ms-1 me-1 fs-2">
                <button data-bs-toggle="modal" data-bs-target="#store-modal" style="border: none; 
                background: none!important; padding: 0!important; color: #0D6EFD;">
                Add to Database
                </button>                
                <p class="text-secondary">Add product from supplier's inventory file to MySql database</p>
            </div>
        </div>
    </div>

    <div class="row ms-5 me-5 justify-content-center">
        <!-- Remove product from store -->
        <div class="col-4 d-flex row-eq-height">
            <div class="bg-light rounded border border-5 m-2 p-3 text-center" style="width: 100%;">
            <p class="ms-1 me-1 fs-2">
                <button data-bs-toggle="modal" data-bs-target="#delete-modal" style="border: none; 
                background: none!important; padding: 0!important; color: #0D6EFD;">
                Delete Product
                </button>                <p class="text-secondary">Remove a product from your Shopify store</p>
            </div>
        </div>
    </div>

    {{-- Start inventFile modal --}}

    <div class="modal fade" id="inventFile-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="modal-title">Download Inventory File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="invent-form">
                            <form action="/inventFile" method="POST">
                            @csrf
                                <div class="form-group">
                                    <label for="showID">Supplier:&nbsp;</label>
                                    <select class="form-control mt-2" name="supplier" id="supplier">
                                        <option value="CWR">CWR</option>
                                        <option value="TWH">TWH</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Submit</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- End inventFile modal --}}

    {{-- Start index modal --}}

    <div class="modal fade" id="inventFile-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="modal-title">Download Inventory File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="invent-form">
                            <form action="/inventFile" method="POST">
                                @csrf
                                <label for="showID">Supplier:&nbsp;</label>
                                <select name="supplier" id="supplier">
                                    <option value="CWR">CWR</option>
                                    <option value="TWH">TWH</option>
                                </select>
                                <input type="hidden" id="functionality" name="functionality" value="File Successfully Donwloaded!">
                                <input type="submit" value="Download">                              
                                
                                <div class="modal-footer">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- End index modal --}}

    {{-- Start show modal --}}

    <div class="modal fade" id="show-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="modal-title">Get Item By ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/show" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="showID ">Enter Item ID:&nbsp;</label>
                            <input type="text" class="form-control" id="id" name="id" required 
                            oninvalid="this.setCustomValidity('Item identifier is required')">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- End show modal --}}

    {{-- Start create modal --}}

    <div class="modal fade" id="create-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/create" method="POST">
                            @csrf
                            <label for="showID">Supplier:&nbsp;</label>
                            <select class="form-control mt-2" name="supplier" id="supplier">
                                <option value="CWR">CWR</option>
                                <option value="TWH">TWH</option>
                            </select>
                            <label for="showID">Item Identifier:&nbsp;</label>
                            <input type="text" class="form-control" id="itemId" name="itemId" required 
                            oninvalid="this.setCustomValidity('Item identifier is required')">
                            <button type="submit" class="btn btn-primary mt-2">List Item</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- End create modal --}}

    {{-- Start update modal --}}

    <div class="modal fade" id="update-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="modal-title">Update Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/update" method="POST">
                            @csrf
                            <label for="showID">Supplier:&nbsp;</label>
                            <select class="form-control mt-2" name="supplier" id="supplier">
                                <option value="CWR">CWR</option>
                                <option value="TWH">TWH</option>
                            </select>
                            <label for="showID">Item Identifier:&nbsp;</label>
                            <input type="text" class="form-control" id="itemId" name="itemId" required 
                            oninvalid="this.setCustomValidity('Item identifier is required')">
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- End update modal --}}

    {{-- Start store modal --}}

    <div class="modal fade" id="store-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="modal-title">Add To Database</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/store" method="POST">
                            @csrf
                            <label for="showID">Item Identifier:&nbsp;</label>
                            <input type="text" class="form-control" id="itemId" name="itemId" required
                            oninvalid="this.setCustomValidity('Item identifier is required')">
                            <label for="showID">Supplier:&nbsp;</label>
                                    <select class="form-control mt-2" name="supplier" id="supplier">
                                        <option value="CWR">CWR</option>
                                        <option value="TWH">TWH</option>
                                    </select>
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- End store modal --}}

    {{-- Start delete modal --}}

    <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="modal-title">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/delete" method="POST">
                            @csrf
                            <label for="showID">Item Identifier:&nbsp;</label>
                            <input type="text" class="form-control" id="itemId" name="itemId" required 
                            oninvalid="this.setCustomValidity('Item identifier is required')">
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- End delete modal --}}

@endsection
