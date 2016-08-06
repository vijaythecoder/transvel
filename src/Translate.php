<?php

namespace Vijaytupakula\Transvel;

use Dedicated\GoogleTranslate\Translator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class Translate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate {--language=} {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this translates everything';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // $this->info($this->option('language'));

        $locales = Config::get('app.locales');

        if($this->option('file') != null)
        {
            $file = base_path('resources/lang/en/'.$this->option('file'));

            foreach ($locales as $localeKey => $value) 
            {
                if($localeKey != 'en')
                {
                   $this->translate($localeKey,$file);
                }
            }   
        }
        else
        {
            $files = File::allFiles(base_path('resources/lang/en'));
            foreach ($files as $file)
            {   
                if($this->option('language') != null)
                {
                    $this->translate($this->option('language'),$file);
                }
                else
                {
                    foreach ($locales as $localeKey => $value) 
                    {
                        if($localeKey != 'en')
                        {
                           $this->translate($localeKey,$file);
                        }
                    
                    }    
                }
            }
        }
        
    }

    function translate($localeKey,$file)
    {

        $translator = new Translator;

         // convert the target language to string
        $targetLang = (string)$localeKey;
        $myArray = include $file;
        $convertedArray = [];
        foreach ($myArray as $langKey => $langValue) {
             if(is_array($langValue))
             {
                foreach ($langValue as $langValueKey => $langSubValue) {
                    $result = $translator->setSourceLang('en')
                             ->setTargetLang($targetLang)
                             ->translate($langValueKey);

                             $convertedArray[$langKey][$langValueKey] = $result;   
                    }
             }
             else
             {
                $result = $translator->setSourceLang('en')
                         ->setTargetLang($targetLang)
                         ->translate($langValue);

                         $convertedArray[$langKey] = $result;   
             }
             
        }

        if(!File::exists(base_path('resources/lang/'.$targetLang))) {
            File::makeDirectory(base_path('resources/lang/'.$targetLang));
        }

        

        $outputFile = str_replace('en', $targetLang, $file);

        file_put_contents($outputFile, '<?php return ' . var_export($convertedArray, true) . ';');

        $this->line('Created file '.$outputFile);
    }   

}
