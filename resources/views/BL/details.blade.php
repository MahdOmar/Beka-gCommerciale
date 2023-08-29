@extends('layouts.dashboard')

@section('content')

<div class="m-3">

  <h4><a class="text-info" href="/dashboard">Dashborad</a> / <a class="text-info" href="/dashboard/BL">Bls</a> / Bl_Details </h4>

</div>

<div  class="shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">
    <div class="d-flex justify-content-end">
     
    
      
      <div>
        <a href="/dashboard/BL/view/{{  request()->route('id') }}" class="btn btn-success  m-2 p-2 text-white" role="button" ><i class="fas fa-print m-1 "></i>Print</a>

      </div>
      @if ($Bl->User_id == $user || Auth::user()->role == "admin")
      
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
                <th>Colis</th>
                <th>Price HT</th>
                <th>Amount</th>
                <th>Options</th>
              </tr>
            </thead>
            <tbody>

                @php
                $total = 0
            @endphp
                @foreach($bldetails as $bl)

            
              @php
              $total = $total + ($bl->Price_HT * $bl->Quantity  )
          @endphp
              <tr>
                <td>{{$bl->Designation}}</td>
                <td>{{$bl->Quantity}} </td>
                <td>{{$bl->Colis}}</td>
                <td>{{ number_format($bl->Price_HT,2,'.',',')}} DA</td>
                <td>{{ number_format($bl->Price_HT * $bl->Quantity ,2,'.',',')}} DA</td>
                @if ($Bl->User_id == $user || Auth::user()->role == "admin")

                <td>
    
                  <a  data-bs-toggle="modal" data-bs-target="#myModal2" class="btn btn-primary text-white" role="button" onclick="getDetails({{ $bl->id }})"><i class="fas fa-edit"></i></a>

                  <button onclick="deleteDetails({{$bl->id}})" id="btn{{$bl->id}}" class='btn btn-danger'><i class="fas fa-trash"></i></button>
          </td>
                    
                @else

                <td>

          </td>
                    
                @endif
                

            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-end">Total</td>
                <td>{{ number_format($total  ,2,'.',',')  }} DA</td>


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
                <label for="Colis" class=" mb-2">Colis:</label>
                <input type="number" id="Colis" class="form-control" name="Colis" step="1"  required>
               
               
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
                <h4 class="modal-title">Update Bl</h4>
               
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              
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




                <div class="form-group m-2 ">
                    <label for="Quantitys" class=" mb-2">Quantity:</label>
                    <input type="number" id="QuantitysE" class="form-control" name="Quantity" step="0.01"  required>
                   
                   
               </div>

               <div class="form-group m-2">
                <label for="Colise" class=" mb-2">Colis:</label>
                <input type="number" id="ColisE" class="form-control" name="Colise" step="1"  required>
               
               
           </div>




               <div class="form-group m-2">
                <label for="price" class=" mb-2">Price:</label>
                <input type="number"  id="priceE" class="form-control" step="1"  name="price" required>
               
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
           if( $('#Des').val() == ''||  $('#Quantitys').val() == '' || $('#Colis').val() == '' || $('#price').val() == ''  )
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

           else if(  $('#Colis').val() < 0)
           {
             $('.error').text("Colis can not be 0 or negative");

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
            'Colis': $('#Colis').val(),
            'price': $('#price').val(),
           


          }
            id =$('#id').val();
            
          console.log(data);
          $.ajax({
             url : '/dashboard/BL/'+id+'/details',
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
             $('#Colis').val('')
            $('#price').val('')

             total = 0;

             fetch(result)
             
               

        
          

                setTimeout(function() { $('.success').text('');
                
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
         url : '/dashboard/BL/details/get',
         data: data,
         type: 'get',
       //  contentType: "application/json; charset=utf-8",
         dataType: 'json',
         success: function(result)
         {
  
       
           
           
          $('#idO').val(result.id),
             $('#DesE').val(result.Designation),
          
             $('#QuantitysE').val(result.Quantity),
             $('#ColisE').val(result.Colis),
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

   if($('#DesE').val() == '' || $('#QuantitysE').val() == '' || $('#ColisE').val() == '' || $('#priceE').val() == ''  )
           {
               $('.errore').text("All fields are required");

              setTimeout(function() { $('.errore').text('');
                }, 3000);
           }

           else if( $('#QuantitysE').val() <= 0  )
           {
             $('.errore').text("Quantity can not be negative");

              setTimeout(function() { $('.errore').text('');
                }, 3000);

           }

           else if( $('#ColisE').val() < 0  )
           {
             $('.errore').text("Colis can not be negative");

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
            'Colis': $('#ColisE').val(),
            'price': $('#priceE').val(),
           
          }
           
            
      
          $.ajax({
             url : '/dashboard/BL/details/update',
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
          url : '/dashboard/Bl/details/delete',
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

            $.each(result, function(key, item){

               total = total + (item.Quantity * item.Price_HT )

               if(result.user == item.User_id)
               {

               

                $('tbody').append('\
                 <tr>\
                    <td>'+item.Designation+'</td>\
                    <td>'+item.Quantity+'</td>\
                    <td>'+item.Colis+'</td>\
                    <td> '+(item.Price_HT).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' DA</td>\
                    <td>'+((item.Price_HT * item.Quantity)  ).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +' DA</td>\
                    <td>\
                      <a  data-bs-toggle="modal" data-bs-target="#myModal2" class="btn btn-primary text-white" role="button" onclick="getDetails('+item.id+')"><i class="fas fa-edit"></i></a>\
                          <button onclick="deleteDetails('+item.id+')" id="btn'+item.id+'" class="btn btn-danger"><i class="fas fa-trash"></i></button>\
                 </td>\
                </tr>')
              }

              else
              {

                $('tbody').append('\
                 <tr>\
                    <td>'+item.Designation+'</td>\
                    <td>'+item.Quantity+'</td>\
                    <td>'+item.Colis+'</td>\
                    <td> '+(item.Price_HT).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' DA</td>\
                    <td>'+((item.Price_HT * item.Quantity)  ).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") +' DA</td>\
                    <td>\
                 </td>\
                </tr>')

              }


             })
             
             $('tbody').append('\
             <tr>\
                  <td colspan="4" class="text-end">Total</td>\
                  <td>'+total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+' DA</td>\
                </tr>');


            
        

}

 







 



</script>