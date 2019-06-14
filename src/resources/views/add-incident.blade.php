@extends('layouts.master')
@section('content')
<div id="id03" class="add_incident">
    <table>
        <h1>Add Emergency Incident</h1>
        <form method = "post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
        <tr>
            <td><label for="category">Category:</label></td>
            <td><select class="form-control" id="sel3" name="category" required>
                @foreach($category_info as $category)
                    <option value = {{$category->category_id}} > {{$category->type}} </option> <!-- html design -->
                @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="incident_id">Incident ID:</label></td>
            <td></td>
        </tr>
        <tr>
            <td><label for="date">Date:</label></td> <!-- MM/DD/YY -->
            <td><input type="text" class="form-control" id="datepicker" placeholder="Enter Date" name="date" required></td>
        </tr>
        <tr>
            <td><label for="description">Description:</label></td>
            <td><input type="text" class="form-control" id="description" placeholder="Enter Description" name="description" required></td>
        </tr>
    </table>
    
    <hr>

    <footer>
        <span class="cancel"></span>
        <a href="/main"><button type="button" class="btn btn-secondary">Cancel</button></a>
        <button type="submit" id="incident-save" class="btn btn-primary save">Save</button>
    </footer>
        </form>
</div>

@endsection