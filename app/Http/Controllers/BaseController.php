<?php

namespace App\Http\Controllers;
use App\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    //
    public function Login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
         
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $tokenResult =  $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if($request->remember_me){
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();
 
            return response()->json([
                'access_token'=>$tokenResult->accessToken,
                'token_type' => 'Bearer', 
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]);
        }else{
            return response()->json(['error'=>'Unauthorized'],401);
        }
    }

    public function Register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            're_password' => 'required|same:password',
        ]);
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = DB::table('users')->insert([
            'email' => $input['email'],
            'name' => $input['name'],
            'password' => $input['password'],
        ]);
        
        $success['token'] =  $user->createToken('Personal Access Token')->accessToken;
        $success['name']  = $user->name;
 
        return response()->json(['success'=>$success],200); 
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['massage'=>'berhasil logout'],200);
    }


    public function Tambah(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'namaBarang' => 'required',
            'deskripsiBarang'  => 'required',
            'tanggalBarang' => 'required',
        ]);
        $input = $request->all();
        DB::table('barang')->insert([
            'namaBarang' => $input['nama_barang'],
            'deskripsiBarang' => $input['deskripsi_barang'],
            'tanggalBarang' => $input['tanggal_barang'],
            'id_user' => $id
        ]);
       return response()->json("dibuat", 200); 

    }

    public function Delete($id){
        DB::table('barang')->where('idBarang',$id)->delete();
        return response()->json("deleted", 200); 

    }

    public function Edit($id){
        DB::table('barang')->where('id',$id)->update([
            'namaBarang' => $input['nama_barang'],
            'deskripsiBarang' => $input['deskripsi_barang'],
            'tanggalBarang' => $input['tanggal_barang'],
            'idGudang' => $input['id_gudang'] 
            'id_user' => $id
        ]);
        return response()->json("updated", 200); 
    }
}
