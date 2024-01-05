<?php
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


if (!function_exists('isSluggable')) {
    function isSluggable($value)    {
      return Str::slug($value);

    }
}

if (!function_exists('genrateOtp')) {
    function genrateOtp($digit = 4)
    {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $digit; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result < 1000 ? genrateOtp() : $result;
    }
}



if (!function_exists('isMobileDevice')) {
    function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
                            |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
                            , $_SERVER["HTTP_USER_AGENT"]);
    }
}

if (!function_exists('sidebar_open')) {
    function sidebar_open($routes = []) {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

    return $open ? 'text-indigo-500' : 'text-slate-200';
    }
}
if (!function_exists('slide_down')) {
    function slide_down($routes = []) {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

    return $open ? '!block' : 'hidden';
    }
}
if (!function_exists('arrow_down')) {
    function arrow_down($routes = []) {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

    return $open ? 'rotate-180' : 'rotate-0';
    }
}
if (!function_exists('sidebar_inner_open')) {
    function sidebar_inner_open($routes = []) {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

    return $open ? 'text-indigo-500' : 'text-slate-400';
    }
}

if (!function_exists('sidebar_menu_open')) {
    function sidebar_menu_open($routes = []) {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

    return $open ? 'bg-slate-900' : '';
    }
}

if(!function_exists('authSidebar')){
    function authSidebar($routes = []){
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

    return $open ? 'active' : '';
    }
}

if(!function_exists('getS3URL')){
    function getS3URL($filePath, $fileType = '', $fileAccessMode = 'private') {
        $storageDisk = Storage::disk('s3');

        if($storageDisk->exists($filePath)){
            if($fileAccessMode == 'public'){
                $url = $storageDisk->url($filePath);
            }elseif($fileAccessMode == 'private'){
                $url = $storageDisk->temporaryUrl(
                    $filePath, now()->addMinutes(10080)
                );
            }

            return $url;
        }else{
            if($fileType == 'profilePicture'){
                return asset('assets/frontend/images/no-profile-picture.jpeg');
            }else if($fileType == 'postImage'){
                //return 'https://dummyimage.com/540x400/ffffff/2a3680.png&text=Unable+to+load+this+file';
                return asset('assets/frontend/images/no-image-medium.png');
            }else if($fileType == 'collectionImage'){
                //return 'https://dummyimage.com/150x150/ffffff/2a3680.png&text=Unable+to+load+this+file';
                return asset('assets/frontend/images/no-image-small.png');
            }else if($fileType == 'profilePhotoId'){
                return asset('assets/frontend/images/file-not-found.png');
            }else if($fileType == 'cityImage'){
                return asset('assets/frontend/images/location-placeholder.jpeg');
            }else{
                return false;
            }
        }
    }
}
if(!function_exists('prettyPrint')){
    function prettyPrint($a) {
        echo '<pre>'.print_r($a,1).'</pre>';
    }
}

if (!function_exists('imageResizeAndSave')) {
    function imageResizeAndSave($imageUrl, $type = 'post/image', $filename = null)
    {
        if (!empty($imageUrl)) {


            Storage::disk('public')->makeDirectory($type.'/60x60');
            $path60X60     = storage_path('app/public/'.$type.'/60x60/'.$filename);
            $image = Image::make($imageUrl)->resize(null, 60,
                    function($constraint) {
                        $constraint->aspectRatio();
                    });
            //$canvas->insert($image, 'center');
            $image->save($path60X60, 70);

            //save 350X350 image
            Storage::disk('public')->makeDirectory($type.'/350x350');
            $path350X350     = storage_path('app/public/'.$type.'/350x350/'.$filename);
            $image = Image::make($imageUrl)->resize(null, 350,
                    function($constraint) {
                        $constraint->aspectRatio();
                    });

            $image->save($path350X350, 75);

            return $filename;
        } else { return false; }
    }
}

if (!function_exists('siteSetting')) {
    function siteSetting($key='') {
        return \App\Models\Setting::where('key',$key)->value('value');
    }
}

if(!function_exists('uuidtoid')){
    function uuidtoid($uuid, $table){
        $dbDetails = DB::table($table)
                        ->select('id')
                        ->where('uuid', $uuid)->first();

        if($dbDetails){
            return $dbDetails->id;
        }else{
            abort(404);
        }
    }
}

if(!function_exists('customfind')){
    function customfind($id, $table){
        $dbDetails = DB::table($table)
                        ->find($id);
        if($dbDetails){
            return $dbDetails;
        }else{
            abort(404);
        }
    }
}

if(!function_exists('safe_b64encode')){
    function safe_b64encode($string){
        $pretoken = "";
        $posttoken = "";

        $codealphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codealphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codealphabet.= "0123456789";
        $max = strlen($codealphabet); // edited

        for ($i = 0; $i < 3; $i++) {
            $pretoken .= $codealphabet[rand(0, $max-1)];
        }

        for ($i = 0; $i < 3; $i++) {
            $posttoken .= $codealphabet[rand(0, $max-1)];
        }

        $string = $pretoken.$string.$posttoken;
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
     }
}

if(!function_exists('safe_b64decode')){
    function safe_b64decode($string){
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if($mod4){
            $data .= substr('====', $mod4);
        }

        $data = base64_decode($data);
        $data = substr($data, 3);
        $data = substr($data, 0, -3);

        return $data;
    }
}

if(!function_exists('customEcho')){
    function customEcho($str, $length) {
        if(strlen($str)<=$length) return $str;
        else return substr($str,0,$length) . '...';
    }
}

if(!function_exists('trasactionPriceBreakUp')){
    function trasactionPriceBreakUp($purchaseItemPrice){
        $purchaseItemVatPrice = 0;

        $purchaseItemVatPrice = 0;


        $purchaseItemTotalPrice = ($purchaseItemPrice + $purchaseItemVatPrice);

        return [
            'purchaseItemPrice'      => $purchaseItemPrice,
            'purchaseItemVatPrice'   => $purchaseItemVatPrice,
            'purchaseItemTotalPrice' => $purchaseItemTotalPrice
        ];
    }
}

if(!function_exists('formatTime')){
    function formatTime($time){
        return Carbon::parse($time)->format('dS M, Y, \\a\\t\\ g:i A');
    }
}

if(!function_exists('getSiteSetting')){
    function getSiteSetting($key){
        return \App\Models\Setting::where('key',$key)->value('value');
    }
}

if(!function_exists('mime_check')){
    function mime_check($path){
        if($path){
            $typeArray= explode('.',$path);
            $fileType= strtolower($typeArray[count($typeArray)-1]) ?? 'jpg';
            if($fileType=='png'){
                return 'image/png';
            }elseif($fileType=='jpg' || $fileType=='jpeg'){
                return 'image/jpg';
            }elseif($fileType=='webp'){
                return 'image/webp';
            }elseif($fileType=='mp4'){
                return 'video/mp4';
            }elseif($fileType=='webm'){
                return 'video/webm';
            }
        }
        return 'image/*';
    }
}


if(!function_exists('attributePrice')){
    function attributePrice($attributeValue,$productId){
        return \App\Models\ProductAttribute::where(['product_id'=>$productId,'value'=>$attributeValue])->value('attribute_price');
    }
}





