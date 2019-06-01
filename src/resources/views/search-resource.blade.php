@extends('layouts.master')
@section('content')
<div id="id02" class="add_resource">
    <table>
        <h1>Search Resource</h1>
        <form method = "post" action = "/search-resource">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
        <tr>
            <td><label for="keyword">Keyword:</label></td>
            <td><input type="text" class="form-control" id="keyword" placeholder="Enter a Keyword" name="keyword"></td>
        </tr>
        <tr>
            <td><label for="prim_func">Primary Function:</label></td>
            <td><select class="form-control" id="sel4" name="prim_func" required>
                
                </select></td>
        </tr>
        <tr>
            <td><label for="incident">Incident:</label></td>
            <td><select class="form-control" id="sel5" name="incident" required>
                
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="distance">Distance:</label></td>
            <td> Within <input type="text" class="form-control" id="search_distance" placeholder="Enter Distance" name="distance"> miles of PCC </td>
        </tr>
    </table>
    <hr>

        <footer>
            <span class="cancel"></span>
            <button type="button" class="btn btn-secondary">Cancel</button>
            <button type="submit" id="incident-save" class="btn btn-primary save">Save</button>
        </footer>
        </form>
</div>
@endsection

@foreach( $primary_function as $function )
                    <option value =  {{$function->function_id}} > {{$function->function_id}}. {{$function->description}} </option> <!-- html design -->
                @endforeach

                @foreach($category_info as $category) <!-- change to incident dropdown -->
                    <option value = {{$category->category_id}} > {{$category->type}} </option> <!-- html design -->
                @endforeach