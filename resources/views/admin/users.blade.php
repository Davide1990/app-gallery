@extends('templates/admin')

@section('content')
    
    @if (session()->has('message'))
        @component('components/alert-info')
         {{session('message')}}
        @endcomponent
        
    @endif

    <table class="table" id="users-table">
        <thead>
            <th> Name </th>
            <th> Email </th>
            
            <th> Created At </th>
            <th> Deleted </th>
            <th> Manage User </th>
        </thead>
        <tbody>
       

        </tbody>
    </table>

@endsection

@section('footer')
    @parent
    <script>

    $(function () {
        var dataTable = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('get.users')}}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
            {data: 'deleted_at', name: 'deleted_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#users-table').on('click','.btn-danger,.btn-default',function (el){

        el.preventDefault();
        
        var url = $(this).attr('href');
       
        var tr = this.parentNode.parentNode;
       
        //console.log(dataTable);// un riferimento all'oggetto datatable
        if (confirm('Vuoi cancellare il record?')){
            $.ajax(
            
            url,
            {
                method: this.id.startsWith('delete') ? 'DELETE' : 'PATCH',
                data:{
                    '_token' : Laravel.csrfToken
                },
                
                complete:function($resp){
                
                    if ($resp.responseText == 1){
                        if (url.endsWith('hard=1')){
                            tr.parentNode.removeChild(tr);
                        }
                        alert('record cancellato correttamente');
                        dataTable.ajax.reload();
                    } else {
                        alert ('problem contacting server')
                    }
                }

            }

            )
        }
        

    })



    })        
    
  
    </script>
@endsection

