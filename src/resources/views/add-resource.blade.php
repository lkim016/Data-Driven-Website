@extends('layouts.master')
@section('content')
<div id="id02" class="add_resource">
    <table>
        <h1>New Resource Information</h1>
        <form method = "post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
        <tr>
            <td><label for="resource_id">Resource ID:</label></td>
            <td></td>
        </tr>
        <tr>
            <td><label for="owner">Owner: </label></td>
            <td> {{session('user')}} </td>
        </tr>
        <tr>
            <td><label for="resource_name">Resource Name: </label></td>
            <td><input type="text" class="form-control" id="resource_name" placeholder="Enter a Resource Name" name="resource_name" required></td>
        </tr>
        <tr>
            <td><label for="prim_func">Primary Function: </label></td>
            <td><select class="form-control" id="sel1" name="prim_func" required>
                @foreach( $primary_function as $function )
                    <option value =  {{$function->function_id}}> {{$function->function_id}}. {{$function->description}} </option> <!-- html design -->
                @endforeach
                </select></td>
        </tr>
        <tr>
            <td><label for="sel2">Secondary Functions: (hold shift to select more than one):</label></td>
            <td><select multiple class="form-control" id="sel2" name="sec_func[]">
                <!-- <option> is added with jquery -->
                </select></td>
        </tr>
        <tr>
            <td><label for="description">Description:</label></td>
            <td><input type="text" class="form-control" id="description" placeholder="Enter Description" name="description"></td>
        </tr>
        <tr>
            <td><label for="capa">Capabilities:</label></td>
            <td><input type="text" class="form-control" id="capa" placeholder="Enter Cabapilities" name="capa"></td>
            <td><button type="button" class="btn btn-primary" id="add">Add</button></td>
        </tr>
        <tr>
            <td><label for="distance">Distance from PCC:</label></td>
            <td><input type="text" class="form-control" id="distance" placeholder="Enter Distance" name="distance"></td>
            <td> Miles</td>
        </tr>
        <tr>
            <td><label for="cost">Cost:</label></td>
            <td><input type="text" class="form-control" id="cost" placeholder="Enter Cost" name="cost" required></td>
            <td> Per </td>
            <td> <select name = "unit" required>
                @foreach( $cost_unit as $units )
                    <option value = {{$units->unit_id}}> {{$units->unit}} </option>
                @endforeach
                </select></td>
        </tr>
    </table>
        
    <hr>

    <footer>
        <span class="cancel"></span>
        <button type="button" class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary save">Save</button>
    </footer>
        </form>
</div>

<script type = "text/javascript">
    // PRIMARY AND SECONDARY FUNCTION LOADING JS
    secondary_func();
    $("#sel1").change( function() { secondary_func() } );

    function secondary_func () {
            // got the functions list from controller
            var func = JSON.stringify( {!! $js_func !!} );
            var func_obj = JSON.parse(func);

            // clear out the secondary function option list
            sel2_opt_len = $("#sel2 option").length;
            for (i=1; i <= sel2_opt_len + 1; i++) {
                $("#sel2 option[value=" + i + "]").remove();
            }

            // loop through and check if $(#sel1).val() = func_obj[i][description]
            for (item in func_obj) {
                // need to check what value was selected in the JSON array
                var id = func_obj[item]['function_id'];
                var desc = func_obj[item]['description'];
                // remove the selected primary function option
                prim_func_opt = $("#sel1").val();
                if (id == prim_func_opt){
                    continue;
                } else {
                    $("#sel2").append( $('<option></option>').attr("value", id).text(id + '. ' + desc) );
                }
            }
    };

    // MAKING AN ARRAY THAT STORES ALL OF THE CAPABILITIES
    //$("#add").on("click", function () { // not sure why we chould have an add button here
    //    console.log( $("#capa").val() );
    //})
</script>

@endsection