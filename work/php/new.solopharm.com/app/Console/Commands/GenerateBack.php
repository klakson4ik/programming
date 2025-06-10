<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateBack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admindata {name} {model}';

    private const STUBS_PATH  =  APP_PATH . 'stubsExp/';
    private const MIGRATION_STUB =  self::STUBS_PATH . 'migration.create.stub';
    private const MODEL_STUB =  self::STUBS_PATH . 'model.create.stub';
    private const RESOURCE_STUB =  self::STUBS_PATH . 'resource.create.stub';
    private const MIGRATION_PATH = APP_PATH . 'database/migrations/';
    private const MODEL_PATH = APP_PATH . 'app/Models/';
    private const RESOURCE_PATH = APP_PATH . 'app/MoonShine/Resources/';
    private $tableName;
    private $modelName;
    private $modelResource;
    private $migrationName;
    private $title;
    private $isPage = false;
    private $useResource = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make migration and moonshine data secton with fields';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->generateNames();
        $this->createMigration();
        $this->createModel();
        $this->createResource();
        $this->info($this->resourceSectionInfo());
        $this->info($this->getLangInfo());
    }

    private function generateNames()
    {
        $this->tableName = $this->argument('name');

        $this->migrationName = date('Y_m_j_his') . '_create_' . $this->tableName . '_table.php';
        $this->modelName = $this->argument('model');
        $this->modelResource = $this->modelName . 'Resource';
        $nameArr = explode('_', $this->argument('name'));
        if (count($nameArr) > 1) {

            if ($nameArr[1] == 'page') {
                $this->isPage = true;
            }
        }
        $this->title = $this->readJson($this->tableName)['title'];
    }

    private function createResource()
    {
        $content = $this->getContents(self::RESOURCE_STUB, $this->resourceVariables());
        $this->createFile(self::RESOURCE_PATH . $this->modelResource, $content);
    }

    private function createModel()
    {
        $content = $this->getContents(self::MODEL_STUB, $this->modelVariables());
        $path = self::MODEL_PATH;
        if ($this->isPage) {
            $path .= 'Pages/';
        }
        $this->createFile($path . $this->modelName, $content);
    }

    private function createMigration()
    {
        $content = $this->getContents(self::MIGRATION_STUB, $this->migrationVariables());
        $this->createFile(self::MIGRATION_PATH . $this->migrationName, $content);
    }

    private function resourceVariables()
    {
        return [
            'NAME' => $this->modelResource,
            'MODEL' => $this->isPage ? "Pages\\" . $this->modelName : $this->modelName,
            'DATA' => $this->getResourceData(),
            'FILTER' => $this->getResourceFilters(),
            'USE' => $this->getUsesResource(),
            'SEARCH' => $this->getResourceSearch(),
            'TITLE' => $this->title
        ];
    }


    private function migrationVariables()
    {
        return [
            'TABLE' => $this->tableName,
            'DEFAULT_DATA' => $this->getMigrationDefautlData(),
            'DATA' => $this->getMigrationData()
        ];
    }

    private function modelVariables()
    {
        return [
            'NAMESPACE' => $this->isPage ? '\Pages' : '',
            'NAME' => $this->modelName,
            'DATA' => $this->getModelData(),
        ];
    }


    private function getModelData()
    {
        $array = $this->readJson($this->tableName)['data'];
        $content = "protected \$table = '" . $this->tableName .  "';" . PHP_EOL . PHP_EOL;
        if (count($array) > 0) {
            $content .= "\tprotected \$casts = [" . PHP_EOL;
            foreach ($array as $key => $value) {
                if ($value == 'json') {
                    $content .= "\t\t'" . $key . "' => '" . $value . "'," . PHP_EOL;
                }
            }
            $content .= "\t];";
        }

        return $content;
    }

    private function getResourceData()
    {
        $startContent = $this->getResourceDefaultData();
        var_dump($this->isPage);
        if ($this->isPage) {
            $endContent = "])" . PHP_EOL .
                "])," . PHP_EOL;
        } else {
            $endContent = '';
        }

        $content = $this->getResourceContent();

        return $startContent . $content . $endContent;
    }

    private function getResourceContent()
    {
        $array = $this->readJson($this->tableName);
        $content = '';
        if ($this->isPage) {
            $content .= "Tab::make(__('moonshine::form.tab.main'), [" . PHP_EOL;
            $number = '0';
            foreach ($array['data'] as $key => $value) {
                $arr = explode('_', $key);
                switch(count($arr)) {
                    case 1:
                        $content .= $this->getField($key, $value);
                        break;
                    case 2:
                        if (is_numeric($arr[1])) {
                            $content .= $this->getField($key, $value, $arr[0]);
                        } else {
                            $content .= $this->getField($key, $value, $arr[1]);
                        }
                        break;
                    case 3:
                        if (is_numeric($arr[1]) && $arr[1] != $number) {
                            $number = $arr[1];
                            $content .= "])," . PHP_EOL .
                                "Tab::make('', [" . PHP_EOL;
                        }
                        $content .= $this->getField($key, $value, $arr[2]);
                        break;
                }
            }
        } else {
            foreach ($array['data'] as $key => $value) {
                $arr = explode('_', $key);
                switch(count($arr)) {
                    case 1:
                        $content .= $this->getField($key, $value);
                        break;
                    case 2:
                        $content .= $this->getField($key, $value, $arr[0]);
                        break;
                }
            }
        }
        return $content;
    }

    private function getResourceDefaultData()
    {
        $content = '';
        if ($this->isPage) {
            $content .= "Tabs::make([" . PHP_EOL .
                "\tTab::make(__('moonshine::form.tab.main'), [" . PHP_EOL .
                "\t\tSelect::make(__('moonshine::form.field.lang'), 'lang')" . PHP_EOL .
                "\t\t\t->options([" . PHP_EOL .
                "\t\t\t\t'ru' => __('moonshine::lang.ru')," . PHP_EOL .
                "\t\t\t\t'en' => __('moonshine::lang.en')" . PHP_EOL .
                "\t\t\t])," . PHP_EOL .
                "\t\tHeading::make(__('moonshine::form.head.seo'))," . PHP_EOL .
                "\t\tText::make(__('moonshine::form.field.seo.title'), 'seo_title')->hideOnIndex()," . PHP_EOL .
                "\t\tTextarea::make(__('moonshine::form.field.seo.desc'), 'seo_description')->hideOnIndex()," . PHP_EOL .
                "\t\tTextarea::make(__('moonshine::form.field.seo.keywords'), 'seo_keywords')->hideOnIndex()" . PHP_EOL .
                "\t])," . PHP_EOL;
            $this->useResource = ['Tab', 'Tabs', 'Select', 'TinyMce', 'Heading', 'Textarea', 'Text'];
        } else {
            $content .= "Select::make(__('moonshine::form.field.lang'), 'lang')" . PHP_EOL .
                "->options([" . PHP_EOL .
                "'ru' => __('moonshine::lang.ru')," . PHP_EOL .
                "'en' => __('moonshine::lang.en')" . PHP_EOL .
                "])" . PHP_EOL .
                "->sortable()," . PHP_EOL .
                "SwitchBoolean::make(__('moonshine::form.field.active'), 'active')" . PHP_EOL .
                "->sortable()," . PHP_EOL .
                "Number::make(__('moonshine::form.field.sort'), 'sort')" . PHP_EOL .
                "->min(0)" . PHP_EOL .
                "->default(500)" . PHP_EOL .
                "->sortable()," . PHP_EOL;
            $this->useResource = ['Select', 'SwitchBoolean', 'Number'];
        }

        return $content;
    }


    private function getMigrationDefautlData()
    {
        if ($this->isPage) {
            return "\$table->string('lang')->default('ru');" . PHP_EOL
                . "\t\t\t\$table->string('seo_title')->nullable();" . PHP_EOL
                . "\t\t\t\$table->text('seo_description')->nullable();" . PHP_EOL
                . "\t\t\t\$table->text('seo_keywords')->nullable();";
        } else {
            return "\t\t\t\$table->string('lang')->default('ru');" . PHP_EOL .
                "\t\t\t\$table->unsignedInteger('sort')->default(500);" . PHP_EOL .
                "\t\t\t\$table->boolean('active');";
        }
    }

    private function getMigrationData()
    {
        $array = $this->readJson($this->tableName);
        $content = '';
        $count = 1;
        foreach ($array['data'] as $key => $value) {
            $tmp = "\$table->" . $value . "('" . $key . "')->nullable();";
            if ($count == 1)
                $content .= $tmp . PHP_EOL;
            elseif ($count  == count($array)) $content .= "\t\t\t" . $tmp;
            else $content .= "\t\t\t" . $tmp . PHP_EOL;
            ++$count;
        }

        return $content;
    }

    private function getContents($stub, $variables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($variables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    private function createFile($file, $content)
    {
        $fp = fopen($file . '.php', "w");
        fwrite($fp, $content);
        fclose($fp);
    }

    private function readJson($file)
    {
        $path = APP_PATH . 'database/admindata/';
        if ($this->isPage) {
            $path .= 'pages/';
        }
        $ourData = file_get_contents($path . $file . '.json');
        return json_decode($ourData, true);
    }

    private function getField($key, $value, $cKey = false)
    {
        $cKey = $cKey ?: $key;
        if ($value == 'text') {
            $this->useResource[] = 'TinyMce';
            return "TinyMce::make(__('moonshine::form.field." . $cKey . "'), '" . $key . "')" . PHP_EOL
                . "->hideOnIndex()," . PHP_EOL;
        } elseif ($value == 'string') {
            if ($cKey == 'img' || $cKey == 'svg') {
                $this->useResource[] = 'Image';
                return "Image::make(__('moonshine::form.field.img'), '" . $key . "')" . PHP_EOL .
                    "->dir('/images/" . ($this->isPage ? 'pages' : $this->tableName) . "')" . PHP_EOL .
                    "->disk('public')" . PHP_EOL .
                    "->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])" . PHP_EOL .
                    "->hint(__('moonshine::form.img.format') . ': 427x285.')" . PHP_EOL .
                    "->hideOnIndex()," . PHP_EOL;
            } elseif ($cKey == 'file') {
                $this->useResource[] = 'File';
                return "File::make(__('moonshine::form.field.file'), '" . $key . "')" . PHP_EOL .
                    "->dir('/files/" . ($this->isPage ? 'pages' : $this->tableName) . "')" . PHP_EOL .
                    "->disk('public')" . PHP_EOL .
                    "->allowedExtensions(['pdf'])" . PHP_EOL .
                    "->hint(__('moonshine::form.file.format'))" . PHP_EOL .
                    "->hideOnIndex()," . PHP_EOL;
            } elseif ($cKey == 'url' || $cKey == 'youtube') {
                $this->useResource[] = 'Url';
                return "Url::make(__('moonshine::form.field." . $cKey . "'), '" . $key . "')" . PHP_EOL
                    . "->hideOnIndex()," . PHP_EOL;
            } else {
                $this->useResource[] = 'Text';
                return "Text::make(__('moonshine::form.field." . $cKey . "'), '" . $key . "')" . PHP_EOL
                    . "->hideOnIndex()," . PHP_EOL;
            }
        } elseif ($value == 'json') {
            if ($cKey == 'imgs') {
                $this->useResource[] = 'Image';
                return "Image::make(__('moonshine::form.field.img'), '" . $key . "')" . PHP_EOL .
                    "->dir('/" . ($this->isPage ? 'pages' : $this->tableName) . "')" . PHP_EOL .
                    "->disk('public')" . PHP_EOL .
                    "->allowedExtensions(['jpg', 'png', 'webp', 'jpeg', 'svg'])" . PHP_EOL .
                    "->hint(__('moonshine::form.img.format') . ': x.'. __('moonshine::form.img.some'))" . PHP_EOL .
                    "->hideOnIndex()," . PHP_EOL .
                    "->multiple()" . PHP_EOL .
                    "->removable()" . PHP_EOL .
                    "->nullable()," . PHP_EOL;
            } else {
                $this->useResource[] = 'Json';
                return  "Json::make(__('moonshine::form.field.data'), '" . $key . "')" . PHP_EOL .
                    "->fields([" . PHP_EOL .
                    "Textarea::make(__('moonshine::form.field.title'), 'title')," . PHP_EOL .
                    "Textarea::make(__('moonshine::form.field.text'), 'value')" . PHP_EOL .
                    "])->removable()" . PHP_EOL .
                    "->nullable()" . PHP_EOL .
                    "->hideOnIndex()," . PHP_EOL;
            }
        }
    }

    private function getUsesResource()
    {
        $content = '';
        $decor = ['Tabs', 'Tab', 'Block', 'Heading'];
        $filter = ['SwitchBooleanFilter', 'SelectFilter'];
        $array = array_unique($this->useResource);
        foreach ($array as $value) {
            if (in_array($value, $decor)) {
                $content .= "use MoonShine\Decorations\\" . $value . ";" . PHP_EOL;
            } elseif (in_array($value, $filter)) {
                $content .= "use MoonShine\Filters\\" . $value . ";" . PHP_EOL;
            } else {
                $content .= "use MoonShine\Fields\\" . $value . ";" . PHP_EOL;
            }
        }
        return $content;
    }

    private function getResourceFilters()
    {
        $content = "return [" . PHP_EOL .
            "SelectFilter::make(__('moonshine::form.field.lang'), 'lang')" . PHP_EOL .
            "->options([" . PHP_EOL .
            "'ru' => __('moonshine::lang.ru')," . PHP_EOL .
            "'en' => __('moonshine::lang.en')" . PHP_EOL .
            "])," . PHP_EOL;

        $this->useResource[] = 'SelectFilter';
        if ($this->isPage) {
            return $content .
                "];";
        } else {
            $this->useResource[] = 'SwitchBooleanFilter';
            return $content . PHP_EOL .
                "SwitchBooleanFilter::make(__('moonshine::form.field.active'), 'active')" . PHP_EOL . "];";
        }
    }

    private function getResourceSearch()
    {
        return "return ['title'];";
    }

    private function getLangInfo()
    {
        if ($this->isPage) {
            return "'" . explode('_', $this->tableName)[0]  . "' => [" . PHP_EOL
                . "\t'title' => '" . $this->title  . "'" . PHP_EOL .
                "],";
        } else {
            return "'dynamic' => [" . PHP_EOL
                . "\t'" . $this->tableName . "' => '" . $this->title  . "'" . PHP_EOL .
                "]";
        }
    }

    private function resourceSectionInfo()
    {
        if ($this->isPage) {
            return "MenuGroup::make(__('moonshine::section." . explode('_', $this->tableName)[0] . ".title'), [
                MenuItem::make(__('moonshine::section.static'), new " . $this->modelResource . "())
                    ->icon('app'),
            ]),";
        } else {
            return "MenuItem::make(__('moonshine::section.__.dynamic." . $this->tableName . "'), new " . $this->modelResource . "())
            ->icon('app'),";
        }
    }
}
