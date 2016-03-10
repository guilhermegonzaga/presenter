<?php

use Illuminate\Database\Eloquent\Model;
use Laracodes\Presenter\Presenter;
use Laracodes\Presenter\Traits\Presentable;
use Laracodes\Presenter\Exceptions\PresenterException;

class PresentableTraitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ModelExample
     */
    protected $model;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->model = new ModelExample();
    }

    /**
     * @test
     */
    public function exceptionIfPresenterPropertyNotExists()
    {
        $this->expectException(PresenterException::class);

        $this->getMockObjectGenerator()->getObjectForTrait(Presentable::class)->present();
    }

    /**
     * @test
     */
    public function returnValidPresenterClass()
    {
        $this->assertInstanceOf(Presenter::class, $this->model->present());
    }

    /**
     * @test
     */
    public function cachePresenterInstanceIsWorking()
    {
        $call1 = $this->model->present();
        $call2 = $this->model->present();

        $this->assertSame($call1, $call2);
        $this->assertNotSame($call1, (new ModelExample())->present());
    }

    /**
     * @test
     */
    public function checkPresenterInstanceValidValues()
    {
        $this->assertAttributeEmpty('presenterInstance', $this->model);

        $this->model->present();

        $this->assertAttributeInstanceOf(Presenter::class, 'presenterInstance', $this->model);
    }
}

class ModelExample extends Model
{
    use Presentable;

    protected $presenter = ModelPresenter::class;
}

class ModelPresenter extends Presenter
{
    //
}
