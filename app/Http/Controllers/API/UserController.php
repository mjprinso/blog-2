<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    //
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    /*  public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    } */

    /* public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = "Password missmatch";
                return response($response, 422);
            }
        } else {
            $response = 'User does not exist';
            return response($response, 422);
        }
    } */

    /**
     * @OA\Post(path="/blog-me/public/api/login",
     *   tags={"store"},
     *   summary="Place an order for a pet",
     *   description="",
     *   operationId="placeOrder",
     *   @OA\RequestBody(
     *       required=true,
     *       description="order placed for purchasing the pet",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="email", type="string"),
     *          @OA\Property(property="password", type="string"),
     *          @OA\Property(property="c_password", type="string"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     *   ),
     *   @OA\Response(response=400, description="Invalid Order")
     * )
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $user->api_token = $success['token'];
            $user->save();
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(path="/blog-me/public/api/details",
     *   tags={"store"},
     *   summary="Returns pet user details",
     *   description="Returns logged in user details",
     *   operationId="getInventory",
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *   @OA\Response(
     *     @OA\MediaType(mediaType="application/json"),
     *     response=200,
     *     description="My Response"
     *   ),
     *   @OA\Response(
     *     @OA\MediaType(mediaType="application/json"),
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function logout(Request $request)
    {


        /*  $check = Auth::user();
        if (Auth::user()) { */
        // $check = Auth::check();
        if (Auth::check()) {
            // $user = Auth::user();
            $token = $request->user()->token();
            $token->revoke();
            $user = Auth::user();
            $user->api_token = null;
            $user->save();
            // $request->user()->token()->delete();
            // return response()->json(['message' => $check . 'User logged out successfully'], 200);
            return response()->json(['message' => 'User logged out successfully'], 200);
        }

        // return response()->json(['message' => $check . 'User logged out failed'], 200);
        return response()->json(['message' =>  'User logged out failed'], 200);
    }

    /* public function logout(Request $request)
    {

        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    } */
}
