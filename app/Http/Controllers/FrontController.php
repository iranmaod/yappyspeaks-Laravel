<?php



namespace App\Http\Controllers;

use Illuminate\Http\Response;

use Illuminate\Http\Request;

use App\Models\Category;

use App\Models\CategoryData;

use App\Models\Background;

use App\Models\UserVariation;

use Carbon\Carbon;

class FrontController extends Controller

{

    public function catSlug(Request $request, $slug = Null)

    {
         try {

            if(isset($slug)){

                if(!$request->hasCookie($slug.'-cookie_id')){

                    $slug_category = Category::where('slug',$slug)->first();

                    //Last insert user record

                    $last_variation = UserVariation::where('category_id',$slug_category->id)->latest()->first();

                    $background = Background::where('category_id',$slug_category->id)->inRandomOrder()->limit(1)->first();

                    if(isset($last_variation)){

                        if($last_variation->bg_id == $background->id){

                            $background = Background::where('category_id',$slug_category->id)->inRandomOrder()->limit(1)->first();

                            if($last_variation->bg_id == $background->id){

                                $background = Background::where('category_id',$slug_category->id)->inRandomOrder()->limit(1)->first();

                            }

                        }

                    }

                    $anonymousUserId = bin2hex(random_bytes(16));

                    $minutes = 24 * 60;

                   
                    $cookie_id = $anonymousUserId . '-' . $slug_category->slug;

    

                    $end_time = Carbon::now()->addHours(24);

    

                    $user_varation = new UserVariation();

                    $user_varation->cookie_user_id = $cookie_id;

                    $user_varation->category_id = $slug_category->id;

                    $user_varation->bg_id = $background->id;

                    $user_varation->start_time = Carbon::now();

                    $user_varation->end_time = $end_time;

                    $user_varation->status = 1;

                    $user_varation->save();

    

                    //Selected Background and Variation

                    $background = Background::find($user_varation->bg_id);

                    $category = Category::find($user_varation->category_id);

    

                    $response = new Response(view('front.index', compact('category','background')));

                    $response->withCookie(cookie($slug.'-cookie_id', $cookie_id, $minutes));

                    return $response;

                } else {

                    $slug_category = Category::where('slug',$slug)->first();

                    $user_varation = UserVariation::where('cookie_user_id',$request->cookie($slug.'-cookie_id'))->where('category_id',$slug_category->id)->first();

    

                    //Selected Background and Variation

                    $background = Background::find($user_varation->bg_id);

                    $category = Category::find($user_varation->category_id);

    

                    return view('front.index',compact('category','background'));

                }

            }

         } catch (\Exception $e) {

             return redirect()->route('index')->with('error', 'This Category has no Variation or Background.');

         }

          

    }

    public function index(Request $request)

    {

        return view('front.not_found');

    }

}

