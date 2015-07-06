<?php
namespace Services\Support;

trait Path
{

    /**
     * Return path
     *
     * @param $fileName
     * @return string
     */
    protected function getPath($fileName)
    {

        $fileName = $this->templatePath($fileName);

        return $this->path . DIRECTORY_SEPARATOR . $fileName . ".php";
    }

    /**
     * Return path cache html
     *
     * @param $fileName
     * @return string
     */
    protected function getCache($fileName)
    {

        $fileName = $this->templatePath($fileName);

        return CACHE_HTML_PATH . DS . $fileName . ".php";
    }

    /**
     * pattern template
     * @param $fileName
     * @return mixed
     */
    protected function templatePath($fileName)
    {
        return preg_replace('/\./', DIRECTORY_SEPARATOR, $fileName);
    }

}