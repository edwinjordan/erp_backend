<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('generatehtml')){
    
    function rp($x)
    {
        if(is_int($x)==FALSE)
        {
            return '';
        }
        else
        {
           return number_format((int)$x,0,",",".");
        }
    }
       
    function waktu()
    {
        date_default_timezone_set('Asia/Jakarta');
        return date("Y-m-d H:i:s");
    }
              
    function tgl_indo($tgl)
    {
        return substr($tgl, 8, 2).' '.getbln(substr($tgl, 5,2)).' '.substr($tgl, 0, 4);
    }
    
    function tgl_indojam($tgl,$pemisah)
    {
        return substr($tgl, 8, 2).' '.getbln(substr($tgl, 5,2)).' '.substr($tgl, 0, 4).' '.$pemisah.' '.  substr($tgl, 11,8);
    }
    
    
    function getbln($bln)
    {
        switch ($bln) 
        {
            
            case 1:
                return "Januari";
            break;
        
            case 2:
                return "Februari";
            break;
        
            case 3:
                return "Maret";
            break;
        
            case 4:
                return "April";
            break;
        
            case 5:
                return "Mei";
            break;
        
            case 6:
                return "Juni";
            break;
        
            case 7:
                return "Juli";
            break;
        
            case 8:
                return "Agustus";
            break;
        
            case 9:
                return "September";
            break;
        
             case 10:
                return "Oktober";
            break;
        
            case 11:
                return "November";
            break;
        
            case 12:
                return "Desember";
            break;
        }
        
    }
    
    function selisihTGl($tgl1,$tgl2)
    {
        $pecah1 = explode("-", $tgl1);
        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];

        // memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
        // dari tanggal kedua

        $pecah2 = explode("-", $tgl2);
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0];

        // menghitung JDN dari masing-masing tanggal

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);

        // hitung selisih hari kedua tanggal

        $selisih = $jd2 - $jd1;
        return $selisih;
    }
    
    function seoString($s) 
    {
        $c = array (' ');
        $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');

        $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d

        $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
        return $s;
    }
    
    
   
    
    function jmlPaging()
    {
        return 10;
    }
    
    function getusersLogin($idusers,$field)
    {
        $CI =& get_instance();
        $row=$CI->db->get_where('app_users',array('id_users'=>$idusers));
        if($row->num_rows()>0)
        {
            $row=$row->row_array();
            return $row[$field];
        }
        else
        {
            return '';
        }
    }
   
    function getField($tables,$field,$pk,$value)
    {
        $CI =& get_instance();
        $data=$CI->db->query("select $field from $tables where $pk='$value'");
        if($data->num_rows()>0)
        {
            $data=$data->row_array();
            return $data[$field];
        }
        else
        {
            return '';
        }
    }
    
    function ubahtanggal($tanggal)
    {
        return $newtanggal= substr($tanggal,8,2).'-'.substr($tanggal, 5,2).'-'.substr($tanggal, 0,4);
    }
    
    function ubahtanggal2($tanggal)
    {
        return $newtanggal=substr($tanggal,8,2 ).'/'.  substr($tanggal, 5,2).'/'.  substr($tanggal, 0,4);
    }
    
}
