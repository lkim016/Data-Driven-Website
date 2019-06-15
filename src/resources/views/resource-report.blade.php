@extends('layouts.master')
@section('content')
<div id="id05" class="resource_report">
    <table>
        <thead>
            <tr>
                <th><h1>Resource Report</h1></th>
                <!--<th class = "refresh"><h1>&plus;</h1></th>-->
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th class = "res_header"> <h4>Primary Function #:</h4> </th>
                <th class = "res_header"> <h4>Primary Function:</h4> </th>
                <th class = "res_header"> <h4>Total Resources:</h4> </th>
            </tr>
        </thead>
        <tbody>
            @foreach($html_report as $report)
            <tr>
                <td> <p>{{ $report->function_id }}</p> </td>
                <td> <p>{{ $report->function_desc }}</p> </td>
                <td> <p>{{ $report->total_resource }}</p> </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td> <h4>Total</h4> </td>
                <td> <h4>{{$sum}}</h4> </td>
            </tr>
        </tfoot>
    </table>
    
    <hr>

    <footer>
        <span class="cancel"></span>
        <a href="/main"><button type="button" class="btn btn-secondary">Cancel</button></a>
    </footer>
</div>

@endsection