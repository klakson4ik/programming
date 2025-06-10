<?php
class ConvertTwigToBlade
{
    public function __construct($src, $addRegx=[])
    {
        $start = microtime(true);
        $dir = $this->getAllBlocksDir($src);

        $errors = [];

        foreach ($dir as $item) {
            $this->convertBlock($src . $item);
            $error = $this->checkWarning($src . $item);
            if ($error) {
                $errors = array_merge($errors, $error);
            }

        }

        print_r("Конвертирование закончено: ".round(microtime(true) - $start, 4)." сек. \nВсего: " . count($dir) . " | Успешно: " . (count($dir) - count($errors)) . " | С ошибками: " . count($errors)."\n");
    }

    public function convertTwigToBlade($twigTemplate)
    {
        $twigTemplate = str_replace('%}', '', $twigTemplate);
        $twigTemplate = preg_replace('/{% if ([a-zA-Z$0-9_]*)/', '@if (\$$1)', $twigTemplate);
        $twigTemplate = preg_replace('/{% elseif ([a-zA-Z$0-9_]*)/', '@elseif (\$$1)', $twigTemplate);
        $twigTemplate = preg_replace('/{% endif/', '@endif', $twigTemplate);
        $twigTemplate = preg_replace('/{% for (.*) in (.*)/', '@foreach($2 as $1)', $twigTemplate);
        $twigTemplate = preg_replace('/{% endfor/', '@endforeach', $twigTemplate);

        $twigTemplate = preg_replace('/as ([a-zA-Z$0-9_]*)/', 'as \$$1', $twigTemplate);
        $twigTemplate = preg_replace('/foreach\(([a-zA-Z$0-9_]*)/', 'foreach (\$$1', $twigTemplate);

        $twigTemplate = preg_replace('/{{ (.*)\|(.*) }}/', '{{ $1->$2 }}', $twigTemplate);
        $twigTemplate = preg_replace('/{{ (.*) }}/', '{{ $1 }}', $twigTemplate);
        $twigTemplate = preg_replace('/{#(.*)#}/', '', $twigTemplate);
        $twigTemplate = preg_replace('/{ (.)/', '{ \$$1', $twigTemplate);
        $twigTemplate = preg_replace('/([a-zA-Z$]*)\.([a-zA-Z$]*)/', '$1->$2', $twigTemplate);
        $twigTemplate = preg_replace('/^\n/', '', $twigTemplate);
        $twigTemplate = preg_replace('/\n\n/', "\n", $twigTemplate);
        $twigTemplate = preg_replace('/{{ \$renderer->(.*) }}/', '{!! $renderer->$1 !!}', $twigTemplate);

        return $twigTemplate;
    }

    public function newScanDir($dir)
    {
        return array_values(array_diff(scandir($dir), array('.', '..')));
    }

    public function getAllBlocksDir($src)
    {
        $blockGroup = $this->newScanDir($src);

        $blocksDir = [];
        foreach ($blockGroup as $bg) {
            $dirArray = $this->newScanDir($src . $bg);

            foreach ($dirArray as $block) {
                if (!str_contains($block, ".")) {
                    $blocksDir[] = $bg . "/" . $block;
                }

            }

        }

        return $blocksDir;
    }

    public function convertBlock($src)
    {

        foreach ($this->newScanDir($src) as $files) {
            if (str_contains($files, ".html.twig") == 1) {
                $fileName = str_replace(".html.twig", "", $files);
            }
        }

        if (isset($fileName)) {
            $twigTemplate = file_get_contents($src . "/" . $fileName . '.html.twig');
            $bladeTemplate = $this->convertTwigToBlade($twigTemplate);
            file_put_contents($src . "/" . $fileName . '.blade.php', $bladeTemplate);
        }

        return $src;
    }

    public function checkWarning($src)
    {
        foreach ($this->newScanDir($src) as $files) {
            if (str_contains($files, ".blade.php") == 1) {
                $blade = file_get_contents($src . "/" . $files);
                if (str_contains($blade, "{%")) {
                    $errors[] = $src . "/" . $files;
                }
            }
        }

        if (isset($errors)) {
            return $errors;
        }
    }
}


new ConvertTwigToBlade($argv[1], $argv[2]=[]);