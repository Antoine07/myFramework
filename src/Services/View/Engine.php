<?php namespace Services\View;

class Engine
{

    /**
     * @param $value
     * @return mixed
     */
    public function compileStatement($value)
    {
        $callback = function ($match) {
            $render = '';
            if (method_exists($this, $method = 'compile' . ucfirst($match[1]))) {
                $expression = isset($match[2]) ? $match[2] : null;
                $render = $this->$method($expression);
            }

            return isset($match[3]) ? $render . $match[3] : $render;

        };

        $value = $this->variable($value);

        return preg_replace_callback('/@(\w+)(\([^@{}:<\\?\\?>]+\))?/', $callback, $value);
    }

    /**
     * @param $value
     * @return string
     */
    public function variable($value)
    {
        return preg_replace('/{{([^}{@]+)}}/', '<?php echo $1; ?>', $value);
    }

    /**
     * @param $value
     * @return string
     */
    public function variableHtmlentities($value)
    {
        return preg_replace('/{{{([^}{@]+)}}}/', '<?php echo $1; ?>', htmlentities($value, ENT_QUOTES, 'UTF-8', false));
    }

    /**
     * Compile the foreach statements into valid PHP.
     *
     * @param  string $expression
     * @return string
     */
    protected function compileForeach($expression)
    {
        return "<?php foreach{$expression}: ?>";
    }

    /**
     * Compile the if statements into valid PHP.
     *
     * @param  string $expression
     * @return string
     */
    protected function compileIf($expression)
    {
        return "<?php if{$expression}: ?>";
    }

    /**
     * Compile the else-if statements into valid PHP.
     *
     * @param  string $expression
     * @return string
     */
    protected function compileElseif($expression)
    {
        return "<?php elseif{$expression}: ?>";
    }

    /**
     * Compile the while statements into valid PHP.
     *
     * @param  string $expression
     * @return string
     */
    protected function compileWhile($expression)
    {
        return "<?php while{$expression}: ?>";
    }

    /**
     * Compile the end-while statements into valid PHP.
     *
     * @param  string $expression
     * @return string
     */
    protected function compileEndwhile($expression)
    {
        return "<?php endwhile; ?>";
    }

    /**
     * Compile the end-for-each statements into valid PHP.
     *
     * @param  string $expression
     * @return string
     */
    protected function compileEndforeach($expression)
    {
        return "<?php endforeach; ?>";
    }

    /**
     * Compile the end-if statements into valid PHP.
     *
     * @param  string $expression
     * @return string
     */
    protected function compileEndif($expression)
    {
        return "<?php endif; ?>";
    }

}