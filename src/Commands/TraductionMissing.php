<?php

namespace Boblarouche\Traduction\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Lang;
// use Symfony\Component\Process\Exception\ProcessFailedException;
// use Symfony\Component\Process\Process;
// use Illuminate\Support\Facades\Storage;

define('TR_OUTPUT_VALUE', 1);
define('TR_OUTPUT_KEY', 2);


class TraductionMissing extends Command
{
    public $default_lang;
    public $default_path;
    public $target_lang;
    public $target_path;
    public $output_type = 'value';
    public $replace = false;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:missing {--target=} {--output=} {--replace} {--sort}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add missing keys with help of free service';

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
    public function handle()
    {
        $this->default_lang = config('app.fallback_locale');
        $this->default_path = resource_path("lang/{$this->default_lang}");
        $this->target_lang = $this->option('target') ? $this->option('target') : $this->ask('Translate to what language? enter 2 characters e.g. en, fr or es');
        $this->target_path = resource_path("lang/{$this->target_lang}");
        $this->output_type = $this->option('output') ? $this->option('output') : $this->ask('Text output type? (value|key)', 'value');

        if ($this->output_type == 'key') $this->output_type = TR_OUTPUT_KEY;
        if ($this->output_type == 'value') $this->output_type = TR_OUTPUT_VALUE;

        if (!is_dir($this->target_path))
            mkdir($this->target_path);

        $this->line('Default fallback language detected: ' . $this->default_lang);
        $this->line('Target language selected: ' . $this->target_lang);

        setlocale(LC_ALL, $this->default_lang);

        foreach (scandir($this->default_path) as $file) if ($file !== '.' and $file !== '..' and !is_dir("{$this->default_path}/{$file}")) {
            if ($name = trim(str_replace('.php', '', $file)) ?: false)
                if ($translation = Lang::get($name, [], $this->default_lang))
                    if (is_array($translation))
                        $this->processTranslationFile($translation, $name);
        }
    }


    public function processTranslationFile($translation, $name)
    {
        $target_filepath = "{$this->target_path}/{$name}.php";

        $new_values = $this->processTranslationArray($translation, $name);
        dump($new_values);
        $php_array_string = $this->str_array($new_values);

        $php_file_data = "<?php\nreturn {$php_array_string};";

        file_put_contents($target_filepath, $php_file_data);
    }


    public function processTranslationArray($array, $name)
    {
        $out = [];

        foreach ($array as $key => $value) {

            $fullkey = "{$name}.{$key}";

            if (is_array($value)) {
                $out[$key] = $this->processTranslationArray($value, $fullkey);
            } else {

                if (Lang::has($fullkey, $this->target_lang) and $this->replace === false) {
                    $out[$key] = Lang::get($fullkey, [], $this->target_lang);
                } else {
                    // copy default lang to target translation e.g. 'app.title' => 'Title'
                    if ($this->output_type === TR_OUTPUT_VALUE)
                        $out[$key] = $value;

                    // copy language key to target translation e.g. 'app.title' => 'app.title'
                    elseif ($this->output_type === TR_OUTPUT_KEY)
                        $out[$key] = $fullkey;

                    // TODO: Get translation from external translation service as output_type=translate
                }
            }
        }

        if ($this->option('sort'))
            ksort($out);

        return $out;
    }


    public function str_array($array, $indent = 0)
    {
        $tabs = '';
        for ($i = 0; $i <= $indent - 1; $i++)
            $tabs .= "\t";
        $tabs2 = '';
        for ($i = 0; $i <= $indent; $i++)
            $tabs2 .= "\t";

        $str = '[' . PHP_EOL;
        foreach ($array as $key => $value) {
            $key_ = is_integer($key) ? $key : "'{$key}'";
            $str .= $tabs2;
            if (is_array($value)) {
                $str .= "{$key_} => ";
                $indent++;
                $str .= $this->str_array($value, $indent);
                $indent--;
                $str .= "," . PHP_EOL;
            } else {
                $v = str_replace([PHP_EOL, "\n", '"'], ['\n', '\n', '\"'], $value);
                $str .= "{$key_} => \"{$v}\"," . PHP_EOL;
            }
        }
        $indent--;
        return "{$str}{$tabs}]";
    }
}
