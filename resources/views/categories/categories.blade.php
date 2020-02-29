@extends('templates/layout')

@section('content')
@include('partials/errormessage')

    <div class="row">
        <div class="col-9">
            <table class="table" id="listCategory">

                <thead>
                <th> ID </th>
                <th> Category Name </th>
                <th> Created Date </th>
                <th> Number of Albums </th>
                <th> </th>
                </thead>
                <tbody>
                @forelse ($categories as $cat)

                <tr id="category-{{$cat->id}}">
                    <td> {{$cat->id}} </td>
                    <td id="catName-{{$cat->id}}"> {{$cat->category_name}} </td>
                    <td> {{$cat->created_at}} </td>
                    <td> {{$cat->albums_count}} </td>
                    <td> 
                        <div class="d-flex align-items-start justify-content-start">
                            <form id="delForm" action="{{route('categories.destroy',$cat->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button id="btnDelete-{{$cat->id}}" class="btn btn-outline btn-danger btn-sm"> DELETE </button>
                                <a id="upd-{{$cat->id}}" class="btn btn-default btn-sm" href="{{route('categories.edit',$cat->id)}}"> UPDATE </a>
                            </form>
                            
                        </div>
                    </td>
                </tr>

                @empty
                </tr>
                    <td> No Categories </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-3">
            <h2> Add Category </h2>
            @include('categories/categoryform')
        </div>
    </div>
@endsection

@section('footer')
    
    @parent
    <script>
        
    $('document').ready(function(){

        $('#delForm .btn-danger').on('click',function(evt){
            evt.preventDefault();
            var form= this.parentNode;
            var urlCategory = form.action;
            var id=evt.target.id.replace('btnDelete-','')*1;
            var tr = 'category-'+id;
            console.log(urlCategory);
               
                
            if (confirm("Vuoi davvero cancellare la categoria?")){
                $.ajax(
                urlCategory,
                {
                    method:'DELETE',
                    data: {
                        '_token': Laravel.csrfToken
                    },
                    complete:function($resp){
                           
                        if ($resp){
                            // responseText: "{"response":"1"}"
                            console.log($resp.responseText);
                               
                            $rispostaOggetto = JSON.parse($resp.responseText);
                            if ($rispostaOggetto.success){
                            $('#'+tr).remove();
                                
                            }
                            else {
                            alert('Problem contacting server');
                                
                            }
                            } else {
                                
                             alert('Problem contacting server');
                               
                            }
                    }
                }
                )
            }
                
        });




        // add category 

        $('#manageCategoryForm button.btn-success').on('click',function(evt){
            evt.preventDefault();
            var form= $('#manageCategoryForm');
            urlCategory = form.attr('action');
 
            var data = form.serialize();
            console.log(data);
               
          
                $.ajax(
                urlCategory,
                    
                {
                    method:'POST',
                    data: data,
                    complete:function($resp){
                           
                        if ($resp){
                            // responseText: "{"response":"1"}" 
                            console.log($resp.responseText);
                               
                            $rispostaOggetto = JSON.parse($resp.responseText);
                            console.log($rispostaOggetto);
                            if ($rispostaOggetto.success){
                               alert($rispostaOggetto.message);
                                form[0].reset();
                                form[0].category.value ='';
                                if ($rispostaOggetto.id){
                                   
                                    var tdCat = $('#catName-'+$rispostaOggetto.id);
                                    tdCat.text($rispostaOggetto.data.category_name)
                                    //tr.css('border','0px');
                                } else {
                                   
                                }
                            } else {
                                
                            alert('Problem contacting server');
                               
                            }
                        }
                    }   
                }
                )
        
            
        });



     //UPDATE category 


        $('#listCategory a.btn-default').on('click',function(evt){
            evt.preventDefault();
            var form= $('#manageCategoryForm');
            
            var categoryId = this.id.replace('upd-','')*1;
            
            var tdCat = $('#catName-'+categoryId);

            //$('#listCategory tr').css('border-color','transparent');
            var categoryRow = $('#category-'+ categoryId);
            //categoryRow.css('border','1px solid red');


            var categoryName = tdCat.text();
            form[0].category.value = categoryName;
            var urlUpdate = this.href.replace('/edit','');
            form.attr('action',urlUpdate);
            
            if (form.find('[name="_method"]').length === 0){
                var input = document.createElement('input');
                input.type= 'hidden';
                input.name='_method';
                input.value='PATCH';
            }
                
            form[0].appendChild(input);
            console.log(urlUpdate);
             
            /*
            form[0].category.addEventListener('keyup',function(){
                tdCat.text(form[0].category.value);
            }); */    
            
        });

    });
     


    </script>

@endsection