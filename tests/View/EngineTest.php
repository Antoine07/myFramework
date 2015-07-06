<?php

use Services\View\Engine;

class EngineTest extends PHPUnit_Framework_TestCase
{

    protected $engine;

    protected function setUp()
    {
        $this->engine = new Engine();
    }

    /**
     * @test echo engine template
     */
    public function testVariable()
    {
        $this->assertEquals('<h2><?php echo $name; ?></h2>', $this->engine->variable('<h2>{{$name}}</h2>'));
    }

    /**
     * @test foreach test engine template
     */
    public function testRegexForeach()
    {
        $build = $this->engine->compileStatement('@foreach($posts as $post) {{$post->title}} @endforeach');

        $this->assertEquals('<?php foreach($posts as $post): ?> <?php echo $post->title; ?> <?php endforeach; ?>', $build);
    }

    /**
     * @test if else engine
     */
    public function testRegexIfElse()
    {
        $build = $this->engine->compileStatement('@if($test) {{$bar}} @elseif {{$foo}} @endif');

        $this->assertEquals('<?php if($test): ?> <?php echo $bar; ?> <?php elseif: ?> <?php echo $foo; ?> <?php endif; ?>', $build);
    }

    /**
     * @test inception function
     */
    public function testFunction()
    {
        $build = $this->engine->compileStatement('@foreach($p as $t)<h2><a href="{{url(\'post/2\')}}">{{$foo}}</a></h2>@endforeach');

        $this->assertEquals('<?php foreach($p as $t): ?><h2><a href="<?php echo url(\'post/2\'); ?>"><?php echo $foo; ?></a></h2><?php endforeach; ?>', $build);
    }

    /**
     * @test complete example
     */
    public function testCompleteExample()
    {

        $herdoc = <<<TMP
@if(\$test)
<h2>Hello World</h2>
@foreach(\$posts as \$post)
    <h2>{{\$post->title}}</h2>
    <p>{{\$post->author}}</p>
@endforeach
@endif
TMP;

        $result = <<<TMP
<?php if(\$test): ?>
<h2>Hello World</h2>
<?php foreach(\$posts as \$post): ?>
    <h2><?php echo \$post->title; ?></h2>
    <p><?php echo \$post->author; ?></p>
<?php endforeach; ?>
<?php endif; ?>
TMP;

        $build = $this->engine->compileStatement($herdoc);

        $this->assertEquals($result, $build);
    }

}