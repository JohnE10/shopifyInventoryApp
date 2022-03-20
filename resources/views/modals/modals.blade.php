<html>
<head>
    <title>

    </title>
</head>
<body>

{{-- Start InventFile Modal --}}

<div class="modal fade" id="inventFile-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Download Inventory File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invent-form">
                        <form action="/inventFile" method="POST">
                            @csrf
                            <label>Supplier:&nbsp;</label>
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

{{-- End InventFile Modal --}}


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
crossorigin="anonymous"></script>

</body>
</html>

