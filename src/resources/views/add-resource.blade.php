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
            <td><select class="form-control" id="sel1" required>
                @foreach( $primary_function as $function )
                    <option> {{$function->function_id}}. {{$function->description}} </option> <!-- html design -->
                @endforeach
                </select></td>
        </tr>
        <tr>
            <td><label for="sel2">Secondary Functions: (hold shift to select more than one):</label></td>
            <td><select multiple class="form-control" id="sel2">
                    <option>1</option>
                </select></td>
        </tr>
        <tr>
            <td><label for="description">Description:</label></td>
            <td><input type="text" class="form-control" id="description" placeholder="Enter Description" name="description"></td>
        </tr>
        <tr>
            <td><label for="capa">Capabilities:</label></td>
            <td><input type="text" class="form-control" id="capa" placeholder="Enter Cabapilities" name="capa"></td>
            <td><button type="submit" class="btn btn-primary">Add</button></td>
        </tr>
        <tr>
            <td><label for="distance">Distance from PCC:</label></td>
            <td><input type="text" class="form-control" id="distance" placeholder="Enter Distance" name="distance"></td>
            <td> miles</td>
        </tr>
        <tr>
            <td><label for="cost">Cost:</label></td>
            <td><input type="text" class="form-control" id="cost" placeholder="Enter Cost" name="cost" required></td>
            <td> Per </td>
            <td> <select required>
                    <option> day </option>
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

<script>
    $(document).focus(
        function() {
            console.log( $("#sel1").val() );
        }
    );

</script>

@endsection