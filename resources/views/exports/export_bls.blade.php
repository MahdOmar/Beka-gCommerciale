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
            @if ($bl->Factured == "Oui")
            <tr>
                @php
                     $final_total += $total + $total * 0.19 ;
                @endphp
                <td colspan="2"></td>
                <td>Total HT </td>
                <td>{{ number_format($total,2,'.',',')}}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td>Total TTC </td>
                <td>{{ number_format($total + $total * 0.19,2,'.',',')}}</td>
            </tr>

            
                
            @else
            @php
                  $final_total += $total;

            @endphp
            <tr >
                <td colspan="2"></td>
                <td>Total </td>
                <td >{{ number_format($total,2,'.',',')}}</td>
            </tr>
                
            @endif
            

    
            
        @endforeach

        <tr >
            <td colspan="2"></td>
            <td>Final Total  </td>
            <td>{{ number_format($final_total,2,'.',',')}}</td>
        </tr>
     
     
     
  
    </tbody>
   </table>