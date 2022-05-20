<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveIteratorIterator;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class AddLangToArray extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:addAll {lang}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add all Lang to language array';

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
     * @return int
     */
    public function handle(){
        $dirs = ['resources' => base_path() . '/resources/views', 'app' => base_path() . '/app'];
        foreach($dirs as $dir){
            $rdi = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::KEY_AS_PATHNAME);
            foreach (new RecursiveIteratorIterator($rdi, RecursiveIteratorIterator::SELF_FIRST) as $file => $info) {
                if(is_dir($file)) continue;
                $contents = file_get_contents($file);
                $pattern = "/@lang\((?:'|\")(?:[a-zA-Z]|_)+\.(?:[a-zA-Z0-9!?.:',-]|\s)+(?:'|\")\)|Lang::get\((?:'|\")(?:[a-zA-Z0-9]|_)+\.(?:[a-zA-Z0-9!?.:',-]|\s)+(?:'|\")\)/m";
                if(preg_match_all($pattern, $contents, $matches)){
                    foreach($matches as $match){
                        foreach ($match as $string){
                            list($key, $value) = explode('.', $string, 2);

                            if(str_contains($key, '@')) $key = substr($key, 7);
                            else $key = substr($key, 11);

                            $value = substr($value, 0, -2);

                            $temp_dir = base_path() . "/resources/lang/{$this->argument('lang')}/$key.php";
                            $file = fopen($temp_dir, "c");
                            fseek($file, -3, SEEK_END);
                            if(strpos(file_get_contents($temp_dir), "\"$value\"") === false){
                                fwrite($file, "\t\"$value\" => \"$value\",\r\n];");
                            }
                            fclose($file);
                        }
                    }
                }
            }
        }
    }
}
