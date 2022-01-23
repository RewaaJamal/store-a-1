@if(session()->has('success'))
    <div class="alert alert-success">
       {{ session()->get('success')}}
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true" >&times;</span>
       </button>
    </div>   
@endif
@if(session()->has('error'))
    <div class="alert alert-danger">
       {{ session()->get('error')}}
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true" >&times;</span>
       </button>
    </div>   
@endif
