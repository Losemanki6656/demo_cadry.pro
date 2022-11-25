<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\UserTask;

class ExportWorkersToZip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cadries;
    protected $comment;
    protected $languages;
    protected $user;
    protected $passport_files;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cadries, $languages, $user, $comment, $passport_files)
    {
        $this->cadries = $cadries;
        $this->user = $user;
        $this->comment = $comment;
        $this->languages = $languages;
        $this->passport_files = $passport_files;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        $newTask = new UserTask();
        $newTask->user_id = $this->user;
        $newTask->comment = $this->comment;
        $newTask->save();

        $user_time = $this->user . time();

        if($this->passport_files) {
            foreach($this->cadries as $item) {

                $lan = "";
                foreach ($this->languages as $language) {
                   if (in_array($language->id, explode(',',$item->language) )) 
                        $lan = $lan.$language->name.',';
                }
                $lan = substr_replace($lan ,"", -1);
    
                $carers = $item->careers;
                $cadry_relatives = $item->relatives;
                $incentives = $item->incentives;
    
                $content = view('uty.cadry_view',[
                    'cadry' => $item,
                    'lan' => $lan,
                    'carers' => $carers,
                    'cadry_relatives' => $cadry_relatives,
                    'incentives' => $incentives
                ])->render();
    
                $fileName   = $item->last_name . " " . $item->first_name . " " . $item->middle_name;
                Storage::disk('public')->put('ArchiveWords/' . $user_time . '/' . $this->comment . '/' .  $fileName . "/Ma'lumotnoma.doc", \Response::make($content));
                
                if($item->passport_file) File::copy(public_path($item->passport_file->file_path), public_path('storage/ArchiveWords/' . $user_time . '/' .
                   $this->comment . '/' .  $fileName . "/Passport" . '.' . $item->passport_file->file_extension));
                    
            }
    
            $zip_file = $this->comment . '.zip';
            $zip = new \ZipArchive();
            $zip->open( storage_path('app/public/ArchiveWords/' . $user_time . '/' . $zip_file ), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
    
            $path = storage_path('app/public/ArchiveWords/' . $user_time . '/' . $this->comment);
    
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
    
            foreach ($files as $name => $file)
            {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = $this->comment . '/' . substr($filePath, strlen($path) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
    
            $zip->close();

        } else {
            foreach($this->cadries as $item) {

                $lan = "";
                foreach ($this->languages as $language) {
                   if (in_array($language->id, explode(',',$item->language) )) 
                        $lan = $lan.$language->name.',';
                }
                $lan = substr_replace($lan ,"", -1);
    
                $carers = $item->careers;
                $cadry_relatives = $item->relatives;
                $incentives = $item->incentives;
    
                $content = view('uty.cadry_view',[
                    'cadry' => $item,
                    'lan' => $lan,
                    'carers' => $carers,
                    'cadry_relatives' => $cadry_relatives,
                    'incentives' => $incentives
                ])->render();
    
                $fileName   = $item->last_name . " " . $item->first_name . " " . $item->middle_name;
                Storage::disk('public')->put('ArchiveWords/' . $user_time . '/' . $this->comment . '/' . $fileName  . ".doc", \Response::make($content));
    
            }
    
            $zip_file = $this->comment . '.zip';
            $zip = new \ZipArchive();
            $zip->open( storage_path('app/public/ArchiveWords/' . $user_time . '/' . $zip_file ), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
    
            $path = storage_path('app/public/ArchiveWords/' . $user_time . '/' . $this->comment);
    
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
    
            foreach ($files as $name => $file)
            {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = $this->comment . '/' . substr($filePath, strlen($path) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
    
            $zip->close();

        }

        $newTask->file_path = 'storage/ArchiveWords/'. $user_time . '/' . $zip_file;
        $newTask->status = true;
        $newTask->save();

    }
}
