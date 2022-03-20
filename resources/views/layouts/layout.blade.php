<!DOCTYPE html">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- styles -->
            <!-- <link href="/css/main.css" rel="stylesheet"> -->

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <title>Shopify Custom App Demo</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" 
        rel="stylesheet"> -->



    </head>
    <body class="bg-light" style="min-height: 100%;">
        <!-- Header -->
        <section class="bg-success">      

            <div class="col pt-5 text-center">
                <h1 style="color: white;">Shopify Custom App Demo</h1>
            </div>

            <!-- Navbar -->
            <div class="container mt-1">
                <div class="navbar justify-content-end bg-success"> 
                    <!-- Home button -->              
                    <a href="/" class="navbar-brand">
                        <span class="fw-bold pe-5 me-5" style="color: white;">Home</span>
                    </a>
                    <!-- Dropdown menu for other functionalities -->
                    <!-- <div class="dropdown">
                        <button Type="button" id="nav-pages-dropdown" data-bs-toggle="dropdown">
                            <span class="btn dropdown-toggle fw-bold text-secondary">Choose a functionality</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="nav-pages-dropdown">
                            <li><a href="inventFile" class="drop-down-item m-1">Download Inventory File</a></li>
                            <li><a href="index" class="drop-down-item m-1">Show All Items</a></li>
                            <li><a href="singleItem" class="drop-down-item m-1">Get Item by ID</a></li>
                            <li><a href="create" class="drop-down-item m-1">Create Product</a></li>
                            <li><a href="update" class="drop-down-item m-1">Update Product</a></li>
                            <li><a href="addToDB" class="drop-down-item m-1">Add Product to Database</a></li>
                            <li><a href="delete" class="drop-down-item m-1">Delete Product from Store</a></li>

                        </ul>
                    </div> -->
                </div>
                
            </div>


        </section>

        <!-- <hr /> -->
        <!-- Container -->
        <div class="container p-5 bg-white" style=" min-height: 500px;">                
            @yield('content')
        </div>

            <footer style="background: #002E25; height: 100px; bottom: 0; width: 100%;">

                <p style="color: white; text-align: center; padding-top: 30px;">Copyright 2022 Shopify Custom App Demo</p>

            </footer>

            <!-- JavaScript Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
            crossorigin="anonymous"></script>


    </body>
</html>
