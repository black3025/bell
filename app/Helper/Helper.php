namespace App\Helper;

class Helper
{
    public function getbegin($y, $m, $d)
    {
        if($d >= 1 && $d <= 7)
        {
            return ($y ."-". $m ."-". "1");
        }
        else if($d >= 8 && $d <= 15)
        {
            return ($y ."-". $m ."-". "8");
        }
        else if($d >= 16 && $d <= 23)
        {
            return ($y ."-". $m ."-". "16");
        }
        else if($d >= 24)
        {
            $c = date('t',strtotime($y ."-". $m ."-". "1"));
            return ($y ."-". $m ."-". "24");
        }
        else
        {
            return "0000-00-00";
        }
    }

    public function getend($y, $m, $d)
    {
        if($d >= 1 && $d <= 7)
        {
            return ($y ."-". $m ."-". "7");
            
        }
        else if($d >= 8 && $d <= 15)
        {
            return ($y ."-". $m ."-". "15");
        }
        else if($d >= 16 && $d <= 23)
        {
            return ($y ."-". $m ."-". "23");
        }
        else if($d >= 24)
        {
            $bd = date('Y-m-d', strtotime($y ."-". $m ."-". "1"));
            $c = date('t',strtotime($y ."-". $m ."-". "1"));
            return ($y ."-". $m ."-". $c);
        }
        else
        {
            return "";
        }
    }
}