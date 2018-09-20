<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Mediafile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MediaController extends Controller
{

    public function index(){
        $medias = Mediafile::all();
        return view(User::UserRoleName(Auth::user()->id).'.media', compact('medias') );
    }

    public function create (Request $request) {

        error_reporting(0);
        session_start();
        $session_id='1'; //$session id
        define ("MAX_SIZE","20000"); // максимальный размер 2MB
        function getExtension($str)
        {
            $i = strrpos($str,".");
            if (!$i) { return ""; }
            $l = strlen($str) - $i;
            $ext = substr($str,$i+1,$l);
            return $ext;
        }
        // валидация форматов изобржений
        $valid_formats = array("jpg", "png", "gif", "jpeg");
        if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
        {
            $uploaddir = "uploads/"; //Image upload directory
            foreach ($_FILES['photos']['name'] as $name => $value)
            {
                $filename = stripslashes($_FILES['photos']['name'][$name]);
                $size=filesize($_FILES['photos']['tmp_name'][$name]);
                // конвертация расширения изображений к нижнему регистру
                $ext = getExtension($filename);
                $ext = strtolower($ext);
                // проверка расширения
                if(in_array($ext,$valid_formats))
                {
                    $image_name=time().rand('1','10000000').'.'.$ext;
                    $newname=$uploaddir.$image_name;
                    // перемещение файла в папку uploads
                    if (move_uploaded_file($_FILES['photos']['tmp_name'][$name], $newname))
                    {
                        // вставка записи в базу
                        $media = new Mediafile;
                        $media -> name = $filename;
                        $media -> url = $newname;
                        $media -> type = $ext;
                        $media -> save();
                        ?>
                        <?php if(isset($request->modal)) : ?>
                            <div class="imgList">
                                <label for="myCheckbox-<?php echo $media->id; ?>">
                                    <img src="/<?php echo $media->url; ?>"/>
                                    <p class="text-center"><?php echo $media->name; ?></p>
                                </label>
                            </div>
                        <?php else : ?>
                            <div class="imgList">
                                <input type="checkbox" name="image[]" value="<?php echo $media->id; ?>" id="myCheckbox-<?php echo $media->id; ?>" />
                                <label for="myCheckbox-<?php echo $media->id; ?>">
                                    <img src="/<?php echo $media->url; ?>"/>
                                    <p class="text-center"><?php echo $media->name; ?></p>
                                </label>
                            </div>
                        <?php endif; ?>

                        <?php
                    } else { echo "<span class='imgList'>Превышен максимальный лимит по помяти  файла</span>"; }

                } else { echo '<span class="imgList">Не допустимый формат</span>'; }

            } // конец foreach
        }
    }

    public function delete(Request $request){
        foreach ($request->image as $image){
            $media = Mediafile::all()->find($image);
            unlink(public_path($media->url));
            $media -> delete();
        }
        session()->flash('flash_message', 'Удаленно');
        return Redirect::back();
    }

}
