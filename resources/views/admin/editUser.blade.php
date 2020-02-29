@extends('templates/admin')

@section('content')
    
    <div class="row ">

        <div class="col-md-6 justify-content-center offset-md-3">
            
            

            @if ($user->id)

                <form class="form" action="{{route('users.update',$user->id)}}" method="POST">
                {{method_field('PATCH')}}
            @else
                
                <form  class="form" action="{{route('users.store')}}" method="POST">
                
                
            @endif 
            
            {{csrf_field()}}
                <input type="hidden" value="{{$user->id}}" name="id">
                <div class="form-group">
                    <label for="name"> Nome </label>
                    <input type="text" class="form-control" name="name" id="name" value="{{old('name') ? old('name') : $user->name }}">
                    @if ($errors->get('name'))
                        <div class="badge badge-danger">
                            @foreach ($errors->get('name') as $error)
                                {{$error}}
                               
                            @endforeach
                            
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email"> Email </label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email') ? old('email') : $user->email}} ">
                    @if ($errors->get('email'))
                    <div class="badge badge-danger">
                        @foreach ($errors->get('email') as $error)
                            {{$error}}
                           
                        @endforeach
                        
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="role"> Role </label>
                    <select name="role" class="form-control">
                        <option value="default"> </option>
                        <option {{($user->role == 'user' || old('role') == 'user') ? 'selected':'' }} value="user"> User</option>
                        <option {{($user->role == 'admin' || old('role') == 'admin') ? 'selected':'' }} value="admin">Admin</option>
                    </select>
                    @if ($errors->get('role'))
                    <div class="badge badge-danger">
                        @foreach ($errors->get('role') as $error)
                            {{$error}}
                           
                        @endforeach
                        
                    </div>
                    @endif
                </div>  

                <div class="form-group">
                   
                    <button type="submit" class="btn btn-primary"> Save </button>
                    <button type="reset" class="btn btn-danger"> Reset </button>
                </div>
                
                
            </form>         

        </div>

    </div>
   

@endsection