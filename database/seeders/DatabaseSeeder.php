<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application"s database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //	Ma	HoTen	Sdt	DiaChi	Email
        $Arr_ho = ["Lê", "Nguyễn", "Quang", "Trần", "Phạm", "Vũ", "Huyền", "Cao", "Bùi", "Đỗ", "Hồ", "Ngô", "Dương", "Lý", "Phan", "Võ"];
        $Arr_ten = ["Lê", "Tiến", "Quang", "Nhất", "Phạm", "Vũ", "Huyền", "Cao", "Bùi", "Đỗ", "Hồ", "Ngô", "Hiếu", "Lý", "Phan", "Võ", "Thành", "Kiệt", "Thắng", "Trung"];
        $Arr_sdt = [0,1,2,3,4,5,6,7,8,9];
        $Arr_quan = ["quan Thu Duc", "quan 1", "quan 2", "quan 3", "quan 4", "quan 5", "quan 6", "quan 7", "quan 8", "quan 9", "quan 10"];
        for ($i = 0; $i < 2010; $i++) {
            $rdHo = array_rand($Arr_ho);
            $ho = $Arr_ho[$rdHo];

            $rdTen = array_rand($Arr_ten);
            $ten = $Arr_ten[$rdTen];
            $ht = $ho . ' ' . $ten;

            $rd = rand();
            $rdSdt = (string)$rd;
            // $sdt = "0". substr($rdSdt, 0, 10);
            $phone = "";
            for ($r=0; $r < 10; $r++) { 
                $rdPhone = (string)array_rand($Arr_sdt);
               $phone .= $Arr_sdt[$rdPhone];
                 
            }
            $sdt = (float)"0".(float)$phone;
    
            $rdQuan = array_rand($Arr_quan);
            $quan = $Arr_quan[$rdQuan];
            $diachi = 'Đường ' . substr($rdSdt, 0, 3) . ', KP ' . substr($rdSdt, 0, 1) . ' '. $quan . ' TPHCM';
            $email = $this->utf8convert($ht). Str::random(3) .substr($rdSdt, 0, 3) ;
            if ($ho === $ten) {
                $i = $i == 0 ? $i = 0 : $i - 1;
            } else {
               
                $uuid = substr(Str::uuid()->toString(), 0, 18);
                DB::table('users')->insert([
                    'Ma' =>  $uuid,
                    'HoTen' => $ht,
                    'Sdt' =>  $sdt,
                    'DiaChi' => $diachi,
                    'email' => $email . '@gmail.com'
                ]);
            }
        }
    }

    public function RandNumber()
    {
        $phone = "";
       for ($i=0; $i < 9; $i++) { 
            $phone .= (string)rand(0,9);
       }
       return  $phone;
    }

    public function utf8convert($str)
    {

        if (!$str) return false;

        $utf8 = array(

            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'd' => 'đ|Đ',

            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',

            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );

        foreach ($utf8 as $ascii => $uni) $str = preg_replace("/($uni)/i", $ascii, $str);

        $str = preg_replace('/ /', '', $str);
        return $str;
    }
}
