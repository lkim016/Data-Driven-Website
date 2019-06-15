@extends('layouts.master')
@section('content')
<div id="id02" class="add_resource">
    <table>
        <h1>Search Resource</h1>
        <form method = "post" action = "/search-resource">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
        <tr>
            <td><label for="keyword">Keyword:<p>(optional)</p></label></td>
            <td><input type="text" class="form-control" id="keyword" placeholder="Enter a Keyword" name="keyword"></td>
        </tr>
        <tr>
            <td><label for="prim_func">Primary Function:<p>(optional)</p></label></td>
            <td><select class="form-control" id="search_function" name="prim_func">
                <option></option>
                @foreach( $primary_function as $function )
                    <option value =  "{{$function->function_id}}" > {{$function->function_id}}. {{$function->description}} </option> <!-- html design -->
                @endforeach
                </select></td>
        </tr>
        <tr>
            <td><label for="incident">Incident:<p>(optional)</p></label></td>
            <td><select class="form-control" id="search_incident" name="incident">
                <option></option>
                @foreach( $display_incident as $incident)
                    <option value = "{{$incident->incident_id}}">#{{$incident->incident_id}} {{$incident->description}}</option> <!-- html design -->
                @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="distance">Distance:<p>(optional)</p></label></td>
            <td> Within <input type="text" class="form-control" id="search_distance" placeholder="Enter Distance" name="distance"> miles of PCC </td>
        </tr>
    </table>
    
    <hr>

    <footer>
        <span class="cancel"></span>
        <a href="/main"><button type="button" class="btn btn-secondary">Cancel</button></a>
        <button type="submit" id="resource-search" class="btn btn-primary save">Search</button>
    </footer>
        </form>
</div>

<div id = "search-result">
<hr>
    <table>
        <h1>Search Results</h1> <!-- need to have all of this added with ajax -->
        <thead class = "search-head">
        <tr>
                <td><h4>Resource ID</h4></td>
                <td><h4>Resource Name</h4></td>
                <td><h4>Owner</h4></td>
                <td><h4>Cost/Unit</h4></td>
                <td><h4>Distance</h4></td>
            </tr>
        </thead>
        <tbody class = "search-body">
        </tbody>
    </table>
</div>

@endsection
