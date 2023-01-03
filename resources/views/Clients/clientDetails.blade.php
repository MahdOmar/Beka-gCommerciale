
@extends('layouts.dashboard')

@section('content')


<div class="m-3 ">

  <h4><a class="text-info" href="/dashboard">Dashborad</a> / Clients / Client Détails </h4>


</div>
<div  class=" shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">

<div class="row">
    <div class="col-md-4">
        <h4>Client: <b>{{ $Client->Name }}</b></h4>

      </div>

      <div class="col-md-4">
      </div>

  <div class="col-md-4">
    <input type="text" name="search" class="form-control" id="searchP" placeholder="search" >
  </div>
 



</div>
    
 
  
       <table class="table table-bordered table-hover  mt-2"  >
        <thead class="bg-dark text-white">
          <tr>
            
           
            <th class="w-25">BL</th>
            <th class="w-50" >Items</th>
            <th class="w-25" >Quantity</th>
           
           
          </tr>
        </thead>
        <tbody>
            @php
                $color = "orange"
            @endphp


            @foreach ($bls as $bl)
           
            @php
                $bl_details = \App\Models\Bldetails::where('Bl_id',$bl->id)->get();
                
            @endphp
            <tr class="m-1">
                @if ($color == "orange")
                <td  class="align-middle table-warning" rowspan="{{ count( $bl_details) }}">Bl N°{{$bl->Bl_num}}</td>
                @foreach ($bl_details as $details)
                <td class="table-warning">- {{ $details->Designation }}</td>
                <td class="table-warning"> {{ $details->Quantity }}</td>
            </tr>
                @endforeach
                    
                @else
                <td  class="align-middle table-info" rowspan="{{ count( $bl_details) }}">Bl N°{{$bl->Bl_num}}</td>
                @foreach ($bl_details as $details)
                <td class="table-info">- {{ $details->Designation }}</td>
                <td class="table-info"> {{ $details->Quantity }}</td>
            </tr>
                @endforeach
                    
                @endif
                
               
                

            </tr>  
               
                <tr><td colspan="3"></td></tr>
                @php
                    if($color == "orange")
                    {
                        $color = "blue";
                    }
                    else{
                        $color = "orange";

                    }
                @endphp


        
                
            @endforeach

         
         
         
         
      
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

  