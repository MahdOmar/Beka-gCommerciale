@extends('layouts.dashboard')

@section('content')

<div class="m-3">

  <h4><a class="text-info" href="/dashboard">Dashborad</a> / <a class="text-info" href="/dashboard/Factures">Factures</a> / Facture_Details </h4>

</div>

<div  class="shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">
    <div class="d-flex justify-content-end">
     
    
      
      <div>
        <a href="/dashboard/Facture/view/{{  request()->route('id') }}" class="btn btn-success  m-2 p-2 text-white" role="button" ><i class="fas fa-print m-1 "></i>Print</a>

      </div>
      
       
      @if ($Fac->Type == "Proforma N" && ( $Fac->UserId == $user || Auth::user()->role == "admin"))
      <div>
        <a  class="btn btn-dark btn-sm m-2 p-2 text-white " data-bs-toggle="modal" data-bs-target="#myModal" role="button" ><i class="fas fa-plus-square m-1"></i>Add Item</a>

      </div>
          
      @endif
      
          
    </div>  
    
      
           <table class="table  table-hover text-center">
            <thead class="bg-dark text-white">
              <tr>
                
                <th>Designation</th>
                <th>Quantity</th>
                <th>Price HT</th>
                <th>Amount</th>
                <th>Options</th>
              </tr>
            </thead>
            <tbody>

                @php
                $total = 0
            @endphp
                @foreach($fdetails as $fac)

            
              @php
              $total = $total + ($fac->Price_HT * $fac->Quantity  )
          @endphp
              <tr>
                <td>{{$fac->Designation}}</td>
                <td>{{$fac->Quantity}} </td>
                <td>{{ number_format($fac->Price_HT,2,'.',',')}} </td>
                <td>{{ number_format($fac->Price_HT * $fac->Quantity ,2,'.',',')}} </td>
                @if (  ($Fac->UserId == $user || Auth::user()->role == "admin"))

              
        
                <td><a  data-bs-toggle="modal" data-bs-target="#myModal2" class="btn btn-primary text-white" role="button" onclick="getDetails({{ $fac->id }})"><i class="fas fa-edit"></i></a>
                  @if ($Fac->Type =="Proforma N")
                  <button onclick="deleteDetails({{ $fac->id }})" id="btn{{ $fac->id }}" class="btn btn-danger"><i class="fas fa-trash"></i></button>

                  @endif
         </td>
                    
             
                    
              
               

                @endif
               
            </tr>
            @endforeach


            <tr>
                <td colspan="3" class="text-end">Total HT</td>
                <td>{{ number_format($total  ,2,'.',',')  }} </td>


              </tr>

              

              
            <tr>
              @if ($Fac->tva == "19")
              <td colspan="3" class="text-end">Taux TVA 19% </td>
              <td>{{ number_format($total*0.19  ,2,'.',',')  }} </td>
                @else
                <td colspan="3" class="text-end">Taux TVA </td>
                <td>{{ number_format($total*0.09  ,2,'.',',')  }} </td>

                @endif
               

              </tr>

              <tr>
                <td colspan="3" class="text-end">Total TTC</td>
                @if ($Fac->tva == "19")
                <td>{{ number_format($total*1.19   ,2,'.',',')  }} </td>

                @else
                <td>{{ number_format($total*1.09  ,2,'.',',')  }} </td>

                    
                @endif


              </tr>

              
            
            </tbody>
           </table>
          
           
    
    </div>


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add item</h4>
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              
            </div>
            <div class="modal-body">
               <p class="text-success success text-center"></p>
               <p class="text-danger error text-center"></p>
                @csrf
                <input type="number" name="" id="id" value="{{ request()->route('id') }}" style="display: none">
                

                <div class="form-group m-2 ">
                    <label for="Des" class=" mb-2">Designation:</label>
                    <input type="text" id="Des" class="form-control" name="Des"   required>
                   
                   
               </div>


               

                <div class="form-group m-2">
                    <label for="Quantitys" class=" mb-2">Quantity:</label>
                    <input type="number" id="Quantitys" class="form-control" name="Quantity" step="0.01"  required>
                   
                   
               </div>






               <div class="form-group m-2">
                <label for="price" class=" mb-2">Price:</label>
                <input type="number"  id="price" class="form-control" step="1"  name="price" required>
               
           </div>


              
            </div>
            <div class="modal-footer">
                <button
                type="button"
                class="btn btn-danger"
                data-bs-dismiss="modal"
              >
                Fermer
              </button>
              <div class="form-group">
              <button  class="btn btn-dark submit">Add</button>
              </div> 
            </div>
          </form>
          </div>
      
        </div>
      </div>


      <div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Order_Product</h4>
               
              <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              
            </div>
            <div class="modal-body">
         
               <p class="text-success successe text-center"></p>
               <p class="text-danger errore text-center"></p>
              
                <input type="number"  name="" id="idE" value="{{ request()->route('id') }}" style="display: none">
                <input type="number"  name="" id="idO"  style="display: none">

                <div class="form-group m-2 ">
                  <label for="Des" class=" mb-2">Designation:</label>
                  <input type="text" id="DesE" class="form-control" name="Des"   required>
                 
                 
             </div>

             @if ($Fac->Type != "Normal")
              
                <div class="form-group m-2 ">
                    <label for="Quantitys" class=" mb-2">Quantity:</label>
                    <input type="number" id="QuantitysE" class="form-control" name="Quantity" step="0.01"  required>
                   
                   
               </div>

              




               <div class="form-group m-2">
                <label for="price" class=" mb-2">Price:</label>
                <input type="number"  id="priceE" class="form-control" step="1"  name="price" required>
               
           </div>

           @endif


              
            </div>
            <div class="modal-footer">
                <button
                type="button"
                class="btn btn-danger"
                data-bs-dismiss="modal"
              >
                Fermer
              </button>
              <div class="form-group">
              <button  class="btn update btn-dark">Update</button>
              </div> 
            </div>
          </form>
          </div>
      
        </div>
      </div>




@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
   $(function(){
       
       $('.submit').click(function(){
      

           $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
           if(  $('#Des').val() == '' ||   $('#Quantitys').val() == ''|| $('#price').val() == ''  )
           {
               $('.error').text("All fields are required");

              setTimeout(function() { $('.error').text('');
                }, 3000);
           }

           else if(  $('#Quantitys').val() <= 0)
           {
             $('.error').text("Quantity can not be 0 or negative");

              setTimeout(function() { $('.error').text('');
                }, 3000);

           }
        

         

           else if( $('#price').val() < 0  )
           {
             $('.error').text("Price can not be negative");

              setTimeout(function() { $('.error').text('');
                }, 3000);

           }

          

   
           else{

           
         
          var data = {
            'id':$('#id').val(),
            'Des': $('#Des').val(),
            'Quantity': $('#Quantitys').val(),
            'price': $('#price').val(),
           


          }
            id =$('#id').val();
            
          console.log(data);
          $.ajax({
             url : '/dashboard/Facture/'+id+'/details',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {

               if(result.error)
               {
                $('.error').text(result.error )
               }
            
           else 
           {

           

             $('tbody').html('')
          
             $('.success').text("Product added")
           
             $('#Des').val('')
             $('#Quantitys').val('')
            $('#QuantityF').val('')
            $('#QuantityC').val('')
            $('#price').val('')

             total = 0;

             fetch(result)
             
               

        
          

                setTimeout(function() { $('.success').text('');
                $('#myModal').modal('toggle')
            }, 1000);

            




            /*    */
          }

             },
             error: function()
            {
                //handle errors
                alert('error...');
            }
          });

        }
       });
      
   });
   

   function getDetails(id){

$('.success').text("")

$.ajaxSetup({
 headers: {
   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 }
});



     
      var data = {

        'id': id,
       
       
      }

      $.ajax({
         url : '/dashboard/Facture/details/get',
         data: data,
         type: 'get',
       //  contentType: "application/json; charset=utf-8",
         dataType: 'json',
         success: function(result)
         {
  
       
           
           
          $('#idO').val(result.id),
             $('#DesE').val(result.Designation),
          
             $('#QuantitysE').val(result.Quantity),
             $('#priceE').val(result.Price_HT)


          
        
          

         }
      
        ,
         error: function()
        {
            //handle errors
            alert('error...');
        }
      });

}

$(function(){
       
       $('.update').click(function(){
           $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

   if( $('#DesE').val() == '' ||  $('#QuantitysE').val() == '' || $('#priceE').val() == ''  )
           {
               $('.errore').text("All fields are required");

              setTimeout(function() { $('.errore').text('');
                }, 3000);
           }

           else if( $('#QuantitysE').val() < 0  )
           {
             $('.errore').text("Quantity can not be negative");

              setTimeout(function() { $('.errore').text('');
                }, 3000);

           }

           else if( $('#priceE').val() < 0  )
           {
             $('.errore').text("Price can not be negative");

              setTimeout(function() { $('.errore').text('');
                }, 3000);

           }


      else
      {

      
           
          
         
          var data = {
            'idB': $('#idE').val(),
            'id': $('#idO').val(),
            'Des': $('#DesE').val(),
            'Quantity': $('#QuantitysE').val(),
            'price': $('#priceE').val(),
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/Facture/details/update',
             data: data,
             type: 'post',
           //  contentType: "application/json; charset=utf-8",
             dataType: 'json',
             success: function(result)
             {
               if(result.error)
               {
                $('.successe').text('')
                $('.errore').text(result.error)



               }
               
               else{
                $('.errore').text('')
              $('.successe').text('Updated' )
           
          


              total = 0;

              console.log(result);
            
              fetch(result)


               }

               setTimeout(function() { $('.successe').text('');
               $('#myModal2').modal('toggle');
            }, 1000);

      
          

             

             },
             error: function()
            {
                //handle errors
                alert('error...');
            }
          });
        }
       });
      
   });

   function deleteDetails(id)

{
 

   $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }       
    });

    swal({
        title: 'Are you sure?',
        text: 'This record and it`s details will be permanantly deleted!',
        icon: 'warning',
        dangerMode: true,
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {
        if (value) {
       
    $.ajax({
          url : '/dashboard/Facture/details/delete',
          data:{'id':id},
          type: 'delete',
        //  contentType: "application/json; charset=utf-8",
          dataType: 'json',
          success: function(result)
          {
          
         
            total = 0;
            
            fetch(result)

       

          },
          error: function()
         {
           
             alert('error...');
         }
       });

       
      }
    })




}


function fetch (result){


$('tbody').html('')

            $.each(result.bldetails, function(key, item){

               total = total + (item.Quantity * item.Price_HT )
          if(result.facture.Type != 'Normal')
          {
            $('tbody').append('\
                 <tr>\
                    <td>'+item.Designation+'</td>\
                    <td>'+item.Quantity+'</td>\
                    <td> '+(item.Price_HT).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' </td>\
                    <td>'+((item.Price_HT * item.Quantity)  ).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +' </td>\
                    <td><a href="" data-bs-toggle="modal" data-bs-target="#myModal2" class="btn btn-primary text-white" role="button" onclick="getDetails('+item.id+')"><i class="fas fa-edit"></i></a>\
                          <button onclick="deleteDetails('+item.id+')" id="btn'+item.id+'" class="btn btn-danger"><i class="fas fa-trash"></i></button>\
                 </td>\
                </tr>')

          }
          else {
            $('tbody').append('\
                 <tr>\
                    <td>'+item.Designation+'</td>\
                    <td>'+item.Quantity+'</td>\
                    <td> '+(item.Price_HT).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' </td>\
                    <td>'+((item.Price_HT * item.Quantity)  ).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +' </td>\
                    <td><a href="" data-bs-toggle="modal" data-bs-target="#myModal2" class="btn btn-primary text-white" role="button" onclick="getDetails('+item.id+')"><i class="fas fa-edit"></i></a>\
                 </td>\
                </tr>')

          }
               
                


             })
            
           

            if(result.facture.tva == "19")
            {
              $('tbody').append('\
             <tr>\
                  <td colspan="3" class="text-end">Total</td>\
                  <td>'+total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' </td>\
                </tr>\
                <tr>\
                <td colspan="3" class="text-end">Taux TVA 19%</td>\
                <td>'+(total * 0.19).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
              </tr>\
              <tr>\
                <td colspan="3" class="text-end">Total TTC</td>\
                <td>'+(total + total*0.19).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
              </tr> ');


            }

            else
            {
              $('tbody').append('\
             <tr>\
                  <td colspan="3" class="text-end">Total</td>\
                  <td>'+total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' </td>\
                </tr>\
                <tr>\
                <td colspan="3" class="text-end">Taux TVA 09%</td>\
                <td>'+(total * 0.09).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
              </tr>\
              <tr>\
                <td colspan="3" class="text-end">Total TTC</td>\
                <td>'+(total * 1.09).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
              </tr> ');


            }
             
           


            
        

}

 







 



</script>