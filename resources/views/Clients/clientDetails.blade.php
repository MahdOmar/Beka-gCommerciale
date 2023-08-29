
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
    <div class="d-flex align-items-center">
    {{-- <a href="/dashboard/Bls/{{ request()->route('id') }}/export"  class="btn btn-success btn-sm  text-white" ><i class="fas fa-plus-square m-1"></i>Export</a> --}}

    <input type="text" name="search" class="form-control" id="searchP" placeholder="search" >
</div>
  </div>
 



</div>
    
 
  
       <table class="table table-bordered table-hover  mt-2"  >
        <thead class="bg-dark text-white">
          <tr>
            
           
            <th class="w-25">BL</th>
            <th class="w-25" >Items</th>
            <th class="w-25" >Quantity</th>
            <th class="w-25" >Price</th>

           
           
          </tr>
        </thead>
        <tbody>
            @php
                $color = "orange";
                $final_total = 0;
            @endphp


            @foreach ($bls as $bl)
           
            @php
                $bl_details = \App\Models\Bldetails::where('Bl_id',$bl->id)->get();
                $total =0;
                
            @endphp
            <tr class="m-1">
                @if ($color == "orange")
                <td  class="align-middle table-warning" rowspan="{{ count( $bl_details) }}">Bl N°{{$bl->Bl_num}}</td>
                @foreach ($bl_details as $details)
                @php

                $total += $details->Quantity * $details->Price_HT;
                
                    
                @endphp
                <td class="table-warning">- {{ $details->Designation }}</td>
                <td class="table-warning"> {{ $details->Quantity }}</td>
                <td class="table-warning">{{ number_format($details->Price_HT,2,'.',',')}} </td>

            </tr>
                @endforeach
                    
                @else
                <td  class="align-middle table-info" rowspan="{{ count( $bl_details) }}">Bl N°{{$bl->Bl_num}}</td>
                @foreach ($bl_details as $details)
                @php

                $total += $details->Quantity * $details->Price_HT;
               

                    
                @endphp
                <td class="table-info">- {{ $details->Designation }}</td>
                <td class="table-info"> {{ $details->Quantity }}</td>
                <td class="table-info">{{ number_format($details->Price_HT,2,'.',',')}} </td>

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
             @php
                      $final_total += $total;

                @endphp
                <tr >
                    <td colspan="2"></td>
                    <td>Total HT</td>
                    <td >{{ number_format($total,2,'.',',')}}</td>
                </tr>
                
                    
              
                

        
                
            @endforeach

            <tr >
                <td colspan="2"></td>
                <td>Final Total HT  </td>
                <td>{{ number_format($final_total,2,'.',',')}}</td>
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

  