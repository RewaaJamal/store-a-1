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
       <input required type="text" value="{{ old('name', $product->name) }}"  class="form-control @error('name') is-invalid @enderror" name ="name" id="name">
       @error('name')
       <p class= "text-danger"> {{ $message}} </p>
       @enderror

     </div>
   </div>
   <div class="row mb-3">
     <label for="category_id" class="col-sm-2 col-form-label">Category</label>
     <div class="col-sm-10">
       <select name="category_id" id="category_id">
         <option value="">No Category</option>
        @foreach(App\Category::all() as $category)
        <option @if($category->id == old('category_id',$product->category_id)) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
       </select>
       @error('category_id')
       <p class= "text-danger"> {{ $message}} </p>
       @enderror
     </div>
   </div>
   <div class="row mb-3">
     <label for="description" class="col-sm-2 col-form-label">Description</label>
     <div class="col-sm-10">
      <textarea class="form-control" name ="description" id="description">{{ old('description', $product->desc->description) }}</textarea>
      @error('description')
       <p class= "text-danger"> {{ $message}} </p>
       @enderror
    </div>
   </div>
   <div class="row mb-3">
     <label for="image" class="col-sm-2 col-form-label">Image</label>
     <div class="col-sm-10">
       @if($product->image)
       <img width= "500"    src = "{{ asset('storage/'.$product->image) }}">
       @endif
       <input type="file" class="form-control" name ="image" id="image">
       @error('image')
       <p class= "text-danger"> {{ $message}} </p>
       @enderror
     </div>
   </div>
   <div class="row mb-3">
     <label for="price" class="col-sm-2 col-form-label">Price</label>
     <div class="col-sm-10">
       <input  type="number" value="{{ old('price',$product->price) }}"  class="form-control @error('price') is-invalid @enderror" name ="price" id="price">
       @error('price')
       <p class= "text-danger"> {{ $message}} </p>
       @enderror

     </div>
   </div>
   <div class="row mb-3">
     <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
     <div class="col-sm-10">
       <input  type="number" value="{{ old('quantity',$product->quantity) }}"  class="form-control @error('quantity') is-invalid @enderror" name ="quantity" id="quantity">
       @error('quantity')
       <p class= "text-danger"> {{ $message}} </p>
       @enderror

     </div>
   </div>
   <div class="row mb-3">
     <label for="tags" class="col-sm-2 col-form-label">Tags</label>
     <div class="col-sm-10">
       <input  type="text" value="{{ old('tags', $tags ?? '') }}"  class="form-control @error('tags') is-invalid @enderror" name ="tags" id="tags">
       @error('quantity')
       <p class= "text-danger"> {{ $message}} </p>
       @enderror

     </div>
   </div>
   <div class="row mb-3">
      <button class ="btn btn-outline-primary" type = "submit">Save </button>
   </div>