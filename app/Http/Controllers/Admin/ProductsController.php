<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Throwable;
use App\Product;
use App\Category;
use App\ProductDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-any', Product::class);
        /*$products = Product::join('categories','products.category_id','=','categories.id')
                ->select([
                    'products.*',
                    'categories.name as category_name ',
                ])->paginate(1);*/
                //$products = Product::with('category')->withImages()->price(20)->Paginate();
                $request = request();
                $products = Product::with('category')
                ->filter($request->query())
                ->paginate();
               // $products = Product::with('category')->withoutGlobalScope('quantity')->Paginate();
                // SELECT * FROM products 
                // SELECT * FROM categories WHERE ID IN (1,2,3)
                return view('admin.products.index' , [
                    'product' => $products,
                    'filters' => $request->query()

                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Product::class);
       /* if(!Gate::allows('create-product')){
            abort(403,'You donot have permission to create product');
        };*/
        //Gate::authorize('create-product');
        return view('admin.products.create', [
            'product'=> new Product(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        $request->validate( [
            'name'=>'required|max:255',
            'price'=>'numeric',
            'quantity'=>'numeric',
            'category_id'=>'required|exists:categories,id',
            'image'=>'nullable|image',
            'tags'=>'nullable|string',
        ]);
        $data = $request->except(['image','_token','tags' ]);
        $image = null;
        if($request->hasFile('image')&&$request->file('image')->isValid()){
            $image= $request->file('image')->store('images','public');
        }
        $data['image']=$image;

        DB::beginTransaction();
        try{
            $product = Product::create($data);
            $tags = $request->post('tags');
            $this->insertTags($request, $product);
           
            DB::commit();
        } catch(Throwable $e){
            DB::rollBack();
            return redirect()->route('admin.products.index')
            ->with('error','operation faild');
        }
        
        $message = sprintf('Product %s created',$product->name);
        return redirect()->route('admin.products.index')
        ->with('success',$message);




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $product= Product::findOrFail($id);
        $this->authorize('view',$product);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update',$product);
       //$product= Product::findOrFail($id);
        //$tags= $product->tags()->pluck('name')->toArray();
        //$tags = implode(',',$tags);
      return view( 'admin.products.edit', [
          'product'=> $product,
         // 'tags'=> $tags,
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product= Product::findOrFail($id);
        $this->authorize('update',$product);
        $request->validate( [
            'name'=>'required|max:255',
            'price'=>'numeric',
            'quantity'=>'numeric',
            'category_id'=>'required|exists:categories,id',
            'image'=>'nullable|image',
        ]);
        $data = $request->except(['image','_token', 'tags']);
        $image = $product->image;
        if($request->hasFile('image')&& $request->file('image')->isValid()){
            Storage::disk('public')->delete($product->image);
            $image= $request->file('image')->store('images','public');
        
        }
        $data['image']=$image;
        DB::beginTransaction();
        try{
            $desc = ProductDescription::firstOrCreate([
                'product_id'=>$product->id
            ],[
                'description'=>$request->post('description')
            ]);
            $product->update($data);
            $desc->product()->associate($product);
            $this->insertTags($request, $product);
            DB::commit();

        } catch(Throwable $e) {
            DB::rollBack();
            return redirect()->route('admin.products.index')
            ->with('error','operation faild');
        }

       
        
        $message= sprintf('Product %s updated',$product->name);
        return redirect()->route('admin.products.index')
        ->with('success',$message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product= Product::withTrashed()->findOrFail($id);
        $this->authorize('delete',$product);
        if($product->trashed()){
            $product->forceDelete();
           // Storage::disk('public')->delete($product->image);

        }else{
            $product->delete();
        }
        $message= sprintf('Product %s deleted',$product->name);
        return redirect()->route('admin.products.index')
        ->with('success', $message);

    }

    protected function insertTags($request, $product)
    {
        $tags = $request->post('tags');
        $tag_ids = [];
        if($tags){

            $tag_array = explode(',', $tags);
            foreach($tag_array as $tag_name){
              $tag_name = trim($tag_name);
              $tag = Tag::where('name', $tag_name)->first();
              if(!$tag){
                $tag = Tag::create([
                        'name' => $tag_name
                ]);
              }
              $tags_ids[] =$tag->id;
            }
        }
        $product->tags()->sync($tags_ids);          
        /*DB::table('products_tags')->where('product_id','product->id')->delete();
        if($tags){

            $tag_array = explode(',', $tags);
            foreach($tag_array as $tag_name){
              $tag_name = trim($tag_name);
              $tag = Tag::where('name', $tag_name)->first();
              if(!$tag){
                $tag = Tag::create([
                        'name' => $tag_name
                ]);
              }DB::table('products_tags')->insert([
                    'product_id'=>$product->id,
                    'tag_id'=>$tag->id,
              ]);
            }

        }*/

    }
    public function trash()
    {
        return view('admin.products.index',[
            'product'=>Product::onlyTrashed()->paginate()
        ]);
    }
    public function restore(Request $request , $id)
    {
        $product= Product::onlyTrashed()->findOrFail($id);
        $this->authorize('restore',$product);
        $product->restore();
        $message= sprintf('Product %s restored',$product->name);
        return redirect()->route('admin.products.index')
        ->with('success', $message);

    }
    public function __Construct()
    {
        $this->middleware(['auth']);
    }


}
