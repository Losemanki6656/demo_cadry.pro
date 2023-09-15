<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Cadry;
use App\Models\Language;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function download_resume($cadry_id){

        $cadry = Cadry::with([
            'birth_region',
            'birth_city',
            'nationality',
            'party',
            'education',
            'instituts',
            'cadry_degree',
            'cadry_title',
            'incentives',
            'careers',
            'relatives',
            'relatives.relative',
            'resume_staff'
        ])->find($cadry_id);

        $lang = request('lang','cryllic');

        $languages = Language::all();

        if ($lang == 'cryllic')
            $my_template = new \PhpOffice\PhpWord\TemplateProcessor(public_path('resumes/resume_ru.docx'));
        else
            $my_template = new \PhpOffice\PhpWord\TemplateProcessor(public_path('resumes/resume_uz.docx'));

        $fullname = $this->replace($cadry->fullname(), $lang);
        $fullname_rel = $this->replace(($cadry->fullname() . 'ning' ), $lang);

        $post = $cadry->resume_staff;

        $birth_address = $this->replace(($cadry->birth_region->name . ', ' . $cadry->birth_city->name), $lang);

        $instituts = '';
        $i = 0;

        foreach($cadry->instituts as $ins)
        {
            if($i != 0) $instituts = $instituts . ', ';
            $instituts = $instituts . $ins->date2 . ' yil,' . $ins->institut;
            $i ++;
        }
        $instituts = $this->replace($instituts, $lang);

        $specs = $cadry->instituts->pluck('speciality')->toArray();
        $specs = $this->replace(implode(',',$specs) , $lang);

        $lan = '';
        foreach ($languages as $language) {
            if (in_array($language->id, explode(',',$cadry->language) ))
                $lan = $lan.$language->name.',';
        }

        $lan = $this->replace(substr_replace($lan ,'', -1), $lang);

        $types = $cadry->incentives->pluck('type_action')->toArray();
        $type_actions = implode(',', $types);
        if(!$type_actions) $type_actions = 'taqdirlanmagan';

        $type_actions = $this->replace($type_actions, $lang);

        $careers = $cadry->careers;
        $car = [];
        foreach($careers as $career)
        {
            if($career->date2 == '') {
                $dat = $career->date1->format('d/m/Y') . ' h/v';
            }
            else {
                $dat = $career->date1->format('d/m/Y') . '-' . $career->date2->format('d/m/Y');
            }

            $car[] = [
                'career_date' => $this->replace($dat, $lang),
                'career_name' => $this->replace($career->staff, $lang)
            ];
        }


        $cadry_relatives = $cadry->relatives;
        $rels = [];
        foreach($cadry_relatives as $rel)
        {
            $rels[] = [
                'relative' => $this->replace($rel->relative->name, $lang),
                'relative_name' => $this->replace($rel->fullname, $lang),
                'relative_date' => $this->replace($rel->birth_place, $lang),
                'relative_staff' => $this->replace($rel->post, $lang),
                'relative_address' => $this->replace($rel->address, $lang)
            ];
        }

        $my_template->cloneRowAndSetValues('career_date', $car);
        $my_template->cloneRowAndSetValues('relative', $rels);
        $my_template->setValue('fullname', $fullname);

        if(file_exists(public_path('storage/'. $cadry->photo))) {
            $my_template->setImageValue('photo', array('path' => public_path('storage/'. $cadry->photo), 'width' => 113, 'height' => 149, 'ratio' => false));
        }

        $birth = strtotime($cadry->birht_date);
        $birth = date('d-m-Y', $birth);

        $my_template->setValue('staff_date', $this->getStaffDate($post->staff_date ?? '', $lang));
        $my_template->setValue('staff_full', $this->replace($post->staff_full ?? '', $lang));
        $my_template->setValue('birth_date', $birth);
        $my_template->setValue('birth_address', $birth_address);
        $my_template->setValue('nationality', $this->replace($cadry->nationality->name, $lang));
        $my_template->setValue('party', $this->replace($cadry->party->name, $lang));
        $my_template->setValue('education', $this->replace($cadry->education->name,$lang));
        $my_template->setValue('institut', $instituts);
        $my_template->setValue('speciality', $specs);
        $my_template->setValue('academic_degree', $this->replace($cadry->cadry_degree->name, $lang));
        $my_template->setValue('academic_title', $this->replace($cadry->cadry_title->name, $lang));
        $my_template->setValue('languages', $lan);
        $my_template->setValue('incent', $type_actions);
        $my_template->setValue('military_rank', $this->replace($cadry->military_rank, $lang));
        $my_template->setValue('deputy', $this->replace($cadry->deputy, $lang));
        $my_template->setValue('fullname_rel', $fullname_rel);

        $my_template->saveAs(public_path('storage/resumes/' . $this->replaceFileName($fullname) . '.docx'));


        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        return response()->download(public_path('storage/resumes/' .  $fullname  . '.docx'), $fullname .'.docx', $headers)
            ->deleteFileAfterSend(true);

    }

    public function replace($text, $lang)
    {
        if($lang == 'cryllic')
        {
            $lat_1 = [
                ' E',' e','ts',"ch","sh",'Ts',"Ch",'Sh','Yu','yu','Ya','ya','Q','q',"O'","o'","G'","g'",'H','h', 'ye', 'Ye', "O`", "o`","O‘","o‘","''","g‘","G‘","O’","o’"
            ];

            $cyr_1 = [
                ' Э',' э','ц','ч','ш','Ц','Ч','Ш','Ю','ю','Я','я','Қ','қ','Ў','ў','Ғ','ғ','Ҳ','ҳ','е','Е','Ў','ў',"Ў",'ў','"','ғ','Ғ','Ў','ў'
            ];

            $text = str_replace($lat_1, $cyr_1, $text);

            $lat_2 = [
                'Yo','yo'
            ];

            $cyr_2 = [
                'Ё','ё'
            ];

            $text = str_replace($lat_2, $cyr_2, $text);

            $lat = [
                'a','b','v','g','d','e','yo','j','z','i','y','k','l','m','n','o','p',
                'r','s','t','u','f','x','i',"",'e',
                'A','B','V','G','D','J','Z','I','Y','K','L','M','N','O','P',
                'R','S','T','U','F','X','I',"",'E',"'","’","‘"
            ];

            $cyr = [
                'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
                'р','с','т','у','ф','х','ы','ь','э',
                'А','Б','В','Г','Д','Ж','З','И','Й','К','Л','М','Н','О','П',
                'Р','С','Т','У','Ф','Х','Ы','Ь','Э','ъ','ъ','ъ'
            ];

            return str_replace($lat, $cyr, $text);
        }
        else
            if($lang == 'latin')
            {

                $cyr = [
                    'а','б','в','г','д',' е','е','ё','ж','з','и','й','к','л','м','н','о','п',
                    'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
                    'А','Б','В','Г','Д'," Е",'Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
                    'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','Қ','қ','Ў','ў','Ғ','ғ','Ҳ','ҳ', '"'
                ];

                $lat = [
                    'a','b','v','g','d'," ye",'e','yo','j','z','i','y','k','l','m','n','o','p',
                    'r','s','t','u','f','x','ts',"ch","sh","sh","'",'i',"",'e','yu','ya',
                    'A','B','V','G','D'," Ye","Ye","Yo",'J','Z','I','Y','K','L','M','N','O','P',
                    'R','S','T','U','F','X','Ts',"Ch",'Sh','Sht',"'",'I',"",'E','Yu','Ya','Q','q',"O'","o'","G'","g'",'H','h', ''
                ];

                return str_replace($cyr, $lat, $text);

            }
    }

    public function getStaffDate($date, $lang)
    {
        if($date == '')
        {
            if($lang == 'cryllic')
            {
                return " дан";
            }
            else
                if($lang == 'latin')
                {
                    return " dan";

                }
        }

        $month = (int) $date->format('m');
        $day = $date->format('d');
        $year = $date->format('Y');

        if($lang == 'cryllic')
        {
            if($month == 1) return $year . ' йил ' . $day . " январдан";
            if($month == 2) return $year . ' йил ' . $day . " февралдан";
            if($month == 3) return $year . ' йил ' . $day . " мартдан";
            if($month == 4) return $year . ' йил ' . $day . " апрелдан";
            if($month == 5) return $year . ' йил ' . $day . " майдан";
            if($month == 6) return $year . ' йил ' . $day . " июндан";
            if($month == 7) return $year . ' йил ' . $day . " июлдан";
            if($month == 8) return $year . ' йил ' . $day . " августдан";
            if($month == 9) return $year . ' йил ' . $day . " сентябрдан";
            if($month == 10) return $year . ' йил ' . $day . " октябрдан";
            if($month == 11) return $year . ' йил ' . $day . " ноябрдан";
            if($month == 12) return $year . ' йил ' . $day . " декабрдан";
        }
        else
            if($lang == 'latin')
            {
                if($month == 1) return $year . ' yil ' . $day . " yanvardan";
                if($month == 2) return $year . ' yil ' . $day . " fevraldan";
                if($month == 3) return $year . ' yil ' . $day . " martdan";
                if($month == 4) return $year . ' yil ' . $day . " apreldan";
                if($month == 5) return $year . ' yil ' . $day . " maydan";
                if($month == 6) return $year . ' yil ' . $day . " iyundan";
                if($month == 7) return $year . ' yil ' . $day . " iyuldan";
                if($month == 8) return $year . ' yil ' . $day . " avgustdan";
                if($month == 9) return $year . ' yil ' . $day . " sentyabrdan";
                if($month == 10) return $year . ' yil ' . $day . " oktyabrdan";
                if($month == 11) return $year . ' yil ' . $day . " noyabrdan";
                if($month == 12) return $year . ' yil ' . $day . " dekabrdan";

            }
    }


    public function replaceFileName($text)
    {

        $cyr = ['.',',','/'];

        $lat = ['','',''];

        return str_replace($cyr, $lat, $text);
    }
}
