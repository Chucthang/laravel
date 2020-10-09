<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Str;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyControllers extends Controller
{

    public function All_Limit()
    {
        $user_limit = Users::orderBy('id', 'desc')->skip(0)->take(20)->get();
        $user_all = Users::orderBy('id', 'desc')->count();
        $Ma_all = Users::all('Ma');
        $Sdt_all = Users::all('Sdt');
        $Email_all = Users::all('Email');

        return view('welcome', [
            'all' => $user_all,
            'limit' => json_encode($user_limit),
            'currentPage' => '',
            'Ma' => json_encode($Ma_all),
            'Sdt' => json_encode($Sdt_all),
            'Email' => json_encode($Email_all)
        ]);
    }

    public function Paginate($data)
    {

        if ($data <= 1) {
            $data = 0;
        } else {
            $assg = ($data - 2);
            $data =  ($data + $assg) * 10;
        }
        $user_limit = Users::orderBy('id', 'desc')->skip($data)->take(20)->get();
        return json_encode($user_limit);
    }
    public function Paginate_pageload($data)
    {


        if ($data <= 1) {
            $data = 0;
        } else {
            $assg = ($data - 2);
            $data =  ($data + $assg) * 10;
        }
        $user_limit = Users::orderBy('id', 'desc')->skip($data)->take(20)->get();
        $user_all = Users::orderBy('id', 'desc')->count();
        $Ma_all = Users::all('Ma');
        $Sdt_all = Users::all('Sdt');
        $Email_all = Users::all('Email');
        return view('welcome', [
            'all' => $user_all, 'limit' => json_encode($user_limit), 'currentPage' => $data,
            'Ma' => json_encode($Ma_all),
            'Sdt' => json_encode($Sdt_all),
            'Email' => json_encode($Email_all)
        ]);
    }

    public function MultipleSearch(Request $request)
    {
        $data = $request->all();

        if ($data['page'] <= 1) {
            $numbpage = 0;
        } else {
            $assg = ($data['page'] - 2);
            $numbpage =  ($data['page'] + $assg) * 10;
        }
        $ss_limit = Users::orderBy('id', 'desc')
            ->orWhere("HoTen", "LIKE", "%" . $data['value'] . "%")
            ->orWhere("HoTen", "LIKE", $data['value'] . "_ %")
            ->orWhere("Ma", "LIKE", "%" . $data['value'] . "%")
            ->orWhere("Sdt", "=", $data['value'])
            ->orWhere("Email", "LIKE", $data['value'] . "_ %")
            ->orWhere("Email", "LIKE", "%" . $data['value'] . "%")
            ->skip($numbpage)->take(20)
            ->get();

        $ss_all = Users::orderBy('id', 'desc')
            ->orWhere("HoTen", "LIKE", "%" . $data['value'] . "%")
            ->orWhere("HoTen", "LIKE", $data['value'] . "_ %")
            ->orWhere("Ma", "LIKE", "%" . $data['value'] . "%")
            ->orWhere("Sdt", "=", $data['value'])
            ->orWhere("Email", "LIKE", $data['value'] . "_ %")
            ->orWhere("Email", "LIKE", "%" . $data['value'] . "%")
            ->count();

        return json_encode(['all' => $ss_all, 'limit' => json_encode($ss_limit), 'currentPage' => '']);
    }


    public function SearchClick(Request $request)
    {
        $data = $request->all();
        if ($data['page'] <= 1) {
            $numbpage = 0;
        } else {
            $assg = ($data['page'] - 2);
            $numbpage =  ($data['page'] + $assg) * 10;
        }
        $ss_limit = Users::orderBy('id', 'desc')
            ->orWhere("HoTen", "LIKE", "%" . $data['value'] . "%")
            ->orWhere("Ma", "LIKE", "%" . $data['value'] . "%")
            ->orWhere("Sdt", "=", $data['value'])
            ->orWhere("Email", "LIKE", "%" . $data['value'] . "%")
            ->skip($numbpage)->take(20)
            ->get();
        return json_encode($ss_limit);
    }

    public function Search_Empty()
    {

        $user_limit = Users::orderBy('id', 'desc')->skip(0)->take(20)->get();
        $user_all = Users::orderBy('id', 'desc')->count();
        return json_encode(['all' => $user_all, 'limit' => json_encode($user_limit), 'currentPage' => '']);
    }

    public function RefeshSearch($txt)
    {

        $ss_limit = Users::orderBy('id', 'desc')
            ->orWhere("HoTen", "LIKE", "%" . $txt . "%")
            ->orWhere("HoTen", "LIKE", $txt . "_ %")
            ->orWhere("Ma", "LIKE", "%" . $txt . "%")
            ->orWhere("Sdt", "=", $txt)
            ->orWhere("Email", "LIKE", $txt . "_ %")
            ->orWhere("Email", "LIKE", "%" . $txt . "%")
            ->skip(0)->take(20)
            ->get();

        $ss_all = Users::orderBy('id', 'desc')
            ->orWhere("HoTen", "LIKE", "%" . $txt . "%")
            ->orWhere("HoTen", "LIKE", $txt . "_ %")
            ->orWhere("Ma", "LIKE", "%" . $txt . "%")
            ->orWhere("Sdt", "=", $txt)
            ->orWhere("Email", "LIKE", $txt . "_ %")
            ->orWhere("Email", "LIKE", "%" . $txt . "%")
            ->get();

        $Ma_all = Users::all('Ma');
        $Sdt_all = Users::all('Sdt');
        $Email_all = Users::all('Email');
        // return json_encode(['all' => json_encode($ss_all),'limit' => json_encode($ss_limit), 'currentPage'=> '']);
        return view('welcome', [
            'all' => json_encode($ss_all),
            'limit' => json_encode($ss_limit), 'currentPage' => '',
            'Ma' => json_encode($Ma_all),
            'Sdt' => json_encode($Sdt_all),
            'Email' => json_encode($Email_all)
        ]);
    }



    public function InsertData(Request $request)
    {
        $uuid = substr(Str::uuid()->toString(), 0, 18);
        $data = $request->all();
        $insert = Users::insert([
            'Ma' => $uuid,
            'HoTen' =>  $data['hoten'],
            'Sdt' =>  $data['sdt'],
            'DiaChi' =>  $data['diachi'],
            'Email' =>  $data['email'],
        ]);

        return json_encode(["data" => $insert, "type" => "", "Maso" =>  $uuid]);
    }



    public function DeleteData($id)
    {
        $del_user = Users::find($id);

        $del_user->delete();


        return json_encode(["data" => $del_user, "id" => $id]);
    }

    public function OneUSer($id)
    {
        $getuser = Users::find($id);

        $getuser->get();


        return json_encode(["data" => $getuser]);
    }

    public function EditUSer(Request $request)
    {
        $user = $request->all();
        $id = $user['id'];
        $update = Users::where('id',  $id)->update([
            'HoTen' =>  $user['hoten'],
            'Sdt' =>  $user['sdt'],
            'DiaChi' => $user['diachi'],
            'Email' => $user['email'],
        ]);


        return  json_encode(["data" => $update]);
    }
}
