@if($errors->any())
<div class="alert alert-danger">
  <ul>
     @foreach($errors->all() as $error ) 
     <li> {{ $error }} </li>
     @endforeach
  </ul>
</div>
@endif
@csrf

<div class="row mb-3">
     <label for="name" class="col-sm-2 col-form-label">Name</label>
     <div class="col-sm-10">
       <input required type="text" value="{{ old('name',$role->name) }}"  class="form-control @error('name') is-invalid @enderror" name ="name" id="name">
       @error('name')
       <p class= "text-danger"> {{ $message}} </p>
       @enderror

     </div>
   </div>

   <div class="row mb-3">
     <label for="name" class="col-sm-2 col-form-label">Permission</label>
     <div class="col-sm-10">
       @foreach(config('permissions') as $perm => $label)
       <div class="form-check">
          <input class="form-check-input" type="checkbox" value="{{$perm}}" name="permissions[]"  @if (in_array($perm , $role_permissions)) checked @endif >
           <label class="form-check-label" for="flexCheckDefault">
              {{$label}}
           </label>
       </div>
       @endforeach
       @error('name')
       <p class= "text-danger"> {{ $message}} </p>
       @enderror

     </div>
   </div>
   
   <div class="row mb-3">
      <button class ="btn btn-outline-primary" type = "submit">Save </button>
   </div>