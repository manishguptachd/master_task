@extends('layouts.app')
@section('content')


  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 content" style="margin-top: 1rem; !important">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center"> Category SubCategory and Product </h3>

            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Product name</th>
                        <th>Category name</th>
                        <th>Sub-Category name</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data as $pData)
                    <tr>
                        <td>{{ $pData['id'] }}</td>
                        <td>{{ $pData['prod_name'] }}</td>
                        <td>{{ $pData['cat_name'] }}</td>
                        <td>{{ $pData['subCat_name'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <?php //echo "<pre>"; //var_dump($data); ?>
            <h3 class="text-center"> Add Product </h3>

            <form id="addproduct">
            {!! csrf_field() !!}
                <div class="form-group">
                    <label for="prod_name">Product name</label>
                    <input type="text" class="form-control" id="prod_name" name="prod_name" placeholder="Product name" required>
                </div>
                <div class="form-group mt-3">
                    <label for="cat_name">Category select</label>
                    <select class="form-control" id="cat_name" name="cat_id">
                    <option value=""> -- Select One --</option>
                        @if (count($category) > 0)

                            @foreach($category as $sData)
                                <option value="{{ $sData['id'] }}">{{ $sData['name'] }}</option>    
                            @endForeach
                        @else
                            No Record Found
                        @endif 

                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="exampleFormControlSelect2">SubCategory select</label>
                    <select class="form-control" id="subCat_name" name="subCat_id">
                    <option value=""> -- Select One --</option>
                        @if (count($subCat) > 0)

                            @foreach($subCat as $cData)
                                <option value="{{ $cData['id'] }}">{{ $cData['name'] }}</option>    
                            @endForeach
                        @else
                            No Record Found
                        @endif 

                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
  </div>


@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();

            $("#addproduct").on('submit', function(e) {
                e.preventDefault();
                var data = $("#addproduct").serialize();
                $.ajax({
                    type: "post",
                    url: "{{ url('add-product') }}",
                    data: data,
                    dataType: "json",
                    success: function(res) {
                        $('#example').dataTable().fnClearTable();
                        $('#example').dataTable().fnDestroy();

                        var table = $("#example tbody");
                        $.each(res.data, function (a, b) {
                            table.append("<tr><td>"+b.id+"</td>" +
                                "<td>"+b.prod_name+"</td>"+
                                "<td>" + b.cat_name + "</td>" +
                                "<td>" + b.subCat_name + "</td></tr>");
                        });

                        $("#example").DataTable();
                        alert(res.msg);
                    },
                    error: function(error) {
                        console.log(error.responseText);
                    }
                });
            });
        } );
    </script>
@stop