
@extends('layouts.dashboard')

@section('content')


<div class="m-3 ">

  <h4><a class="text-info" href="/dashboard">Dashborad</a> / Clients / Etat Client Détails </h4>


</div>
<div  class=" shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">

<div class="row">
    <div class="col-md-4">
        <h4>{{ $Client[0]->Name }}</h4>

      </div>

      <div class="col-md-4">
      </div>

  <div class="col-md-4">
    <input type="text" name="search" class="form-control" id="searchP" placeholder="search" >
  </div>
 



</div>
    
 
  
       <table class="table table-striped table-hover text-center mt-2">
        <thead class="bg-dark text-white">
          <tr>
            
           
            <th>BL</th>
            <th>Paid</th>
            <th>Left</th>
           
           
          </tr>
        </thead>
        <tbody>

            @foreach ( $Bls as $Bl)
            <tr>
              <td>Bon N°{{ $Bl->Designation }}</td>
              <td>{{  number_format($Bl->Amount,2,'.',',') }}</td>
              @foreach ($Bds as $Bd)
              @if ($Bd->id == $Bl->Designation) 
              <td>{{  number_format($Bd->total - $Bl->Amount,2,'.',',') }} </td>
          
     
              @endif
           @endforeach
           @endforeach
            </tr>

         
         
         
      
        </tbody>
       </table>

       <div class="pagination d-flex justify-content-center mt-4 ">
      
    
      </div>
      
       
   
      
      
       
       


</div>
<!-- Transorm Model  -->









        
  @endsection

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  