@extends('layouts.layout')

@section('content')

    <!-- <div class="bg-transparent fs-2 fw-bold text-center mb-5">
        <p>Store Items</p>
    </div> -->

    <div class="row mb-3">
        <div class="col-6 text-center">
            <h3 class="fw-bold">Store Items</h3>
        </div>
    </div>

    <div class="row fw-bold">

        <div class="col-1 text-end">
            <p>&nbsp;</p>
        </div>

        <div class="col-1 text-start fs-5">
            <p>ID</p>
        </div>

        <div class="col-4 ps-5 fs-5">
            <p>Title</p>
        </div>

    </div>

    @php

        for ($i = 0; $i < $x; $i++) { 
            $product_id = $products['products'][$i]['id'];
            $handle = $products['products'][$i]['handle'];
            $title = $products['products'][$i]['title'];
            $product_url = 'https://' . $shop . '.myshopify.com/' . $handle;


            print('<div class="row">');
                print('<div class="col-1 text-end">');
                    print($i+1);
                print('</div>');

                print('<div class="col-1 text-start">');
                    print($product_id);
                print('</div>');

                print('<div class="col ps-5">');
                    print('<a href=' . $product_url . '>' . $title . '</a>');
                print('</div>');

            print('</div>');
        };
    @endphp

    @if(count($errors) > 0)

        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
    @endif


@endsection
